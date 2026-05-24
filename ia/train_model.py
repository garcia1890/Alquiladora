import pandas as pd
from sqlalchemy import create_engine
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score
import joblib

# =========================
# CONEXIÓN A MYSQL
# =========================
usuario = "root"
password = ""
host = "127.0.0.1"
puerto = "3306"
bd = "alquiladora"

engine = create_engine(
    f"mysql+pymysql://{usuario}:{password}@{host}:{puerto}/{bd}"
)

# =========================
# CONSULTA SIMPLE (SIN JOINS)
# =========================
query = """
SELECT
    id,
    estado,
    total,
    DATEDIFF(fecha_fin, fecha_inicio) AS dias_renta
FROM rentas
"""

data = pd.read_sql(query, engine)

print("\n📊 DATOS OBTENIDOS:")
print(data)

# =========================
# VALIDACIÓN DE DATOS
# =========================
if len(data) == 0:
    print("❌ No hay datos en rentas")
    exit()

data = data.dropna()

# =========================
# CREAR VARIABLE OBJETIVO
# =========================
data['cancelado'] = data['estado'].apply(
    lambda x: 1 if x == 'Cancelado' else 0
)

# eliminar estado (texto)
data = data.drop(columns=['estado'])

# =========================
# VARIABLES X y Y
# =========================
X = data[['total', 'dias_renta']]
y = data['cancelado']

# =========================
# DIVISIÓN TRAIN / TEST
# =========================
X_train, X_test, y_train, y_test = train_test_split(
    X,
    y,
    test_size=0.2,
    random_state=42
)

# =========================
# MODELO RANDOM FOREST
# =========================
modelo = RandomForestClassifier(
    n_estimators=100,
    random_state=42
)

modelo.fit(X_train, y_train)

# =========================
# EVALUACIÓN
# =========================
predicciones = modelo.predict(X_test)

accuracy = accuracy_score(y_test, predicciones)

print(f"\n🔥 PRECISIÓN DEL MODELO: {accuracy * 100:.2f}%")

# =========================
# GUARDAR MODELO
# =========================
joblib.dump(modelo, 'modelo_gaos.pkl')

print("\n✅ MODELO GUARDADO COMO modelo_gaos.pkl")