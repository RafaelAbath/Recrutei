import os
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from sqlalchemy import create_engine, text




app = FastAPI()

DATABASE_URL = os.getenv("DATABASE_URL")  
engine = create_engine(DATABASE_URL, pool_pre_ping=True)

class ReportItem(BaseModel):
    plate: str
    make: str
    model: str
    total_rentals: int
    total_revenue: float

@app.get("/reports/revenue", response_model=list[ReportItem])
def get_revenue(start: str, end: str):
    """
    start, end: string YYYY-MM-DD
    Retorna lista com plate, make, model, total_rentals, total_revenue.
    """
    sql = text("""
        SELECT v.plate, v.make, v.model,
               COUNT(r.id)            AS total_rentals,
               SUM(r.total_amount)    AS total_revenue
        FROM rentals r
        JOIN vehicles v ON v.id = r.vehicle_id
        WHERE r.start_date BETWEEN :start AND :end
          AND r.end_date   BETWEEN :start AND :end
        GROUP BY v.id, v.plate, v.make, v.model
    """)
    with engine.begin() as conn:
        result = conn.execute(sql, {"start": start, "end": end})
    
    rows = result.mappings().all()
    return [ReportItem(**row) for row in rows]

