#!/usr/bin/env python3
"""
Prueba la conexión a Google Analytics usando las credenciales configuradas
"""
import os
import sys
from pathlib import Path

# Configurar variables de entorno
credentials_path = Path.home() / ".config/gcloud/application_default_credentials.json"
project_id = "analytics-clients-001"

os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = str(credentials_path)
os.environ["GOOGLE_PROJECT_ID"] = project_id

print("=" * 60)
print("🔍 Probando conexión a Google Analytics")
print("=" * 60)
print(f"\n📝 Credenciales: {credentials_path}")
print(f"🎯 Proyecto: {project_id}")
print(f"✅ Credenciales existen: {credentials_path.exists()}")

# Intentar importar y usar el cliente de Google Analytics
try:
    from google.analytics.data_v1beta import BetaAnalyticsDataClient
    from google.analytics.admin_v1 import AnalyticsAdminServiceClient

    print("\n✅ Librerías de Google Analytics importadas correctamente")

    # Intentar conectarse a Admin API
    admin_client = AnalyticsAdminServiceClient()
    print("✅ Admin Client inicializado")

    # Obtener cuentas
    accounts = admin_client.list_accounts()
    account_list = list(accounts)

    print(f"\n📊 Cuentas encontradas: {len(account_list)}")
    for account in account_list:
        print(f"  - {account.display_name} (ID: {account.name.split('/')[-1]})")

        # Listar propiedades de cada cuenta
        account_id = account.name.split('/')[-1]
        properties = admin_client.list_properties(
            filter_=f'parent:accounts/{account_id}'
        )

        property_list = list(properties)
        print(f"    Propiedades ({len(property_list)}):")
        for prop in property_list:
            prop_id = prop.name.split('/')[-1]
            print(f"      - {prop.display_name} (ID: {prop_id})")

    print("\n✨ ¡Conexión exitosa! Puedes acceder a tus datos de Google Analytics")

except ImportError as e:
    print(f"\n❌ Error de importación: {e}")
    print("\nIntentando instalar dependencias...")
    os.system("pip install google-cloud-analytics-data google-cloud-analytics-admin")

except Exception as e:
    print(f"\n❌ Error de conexión: {e}")
    print("\nVerifica que:")
    print("  1. Las APIs estén habilitadas en Google Cloud")
    print("  2. Las credenciales sean válidas")
    print("  3. Tu cuenta tenga acceso a las propiedades de Google Analytics")
