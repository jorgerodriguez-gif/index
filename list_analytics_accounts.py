#!/usr/bin/env python3
"""
Lista todas las cuentas y propiedades de Google Analytics accesibles
"""
import os
from pathlib import Path
from google.analytics.admin_v1 import AnalyticsAdminServiceClient
from google.analytics.admin_v1.types import ListAccountsRequest

# Configurar credenciales
credentials_path = Path.home() / ".config/gcloud/application_default_credentials.json"
os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = str(credentials_path)

print("=" * 80)
print("📊 CUENTAS Y PROPIEDADES DE GOOGLE ANALYTICS")
print("=" * 80)

try:
    # Crear cliente
    client = AnalyticsAdminServiceClient()

    # Listar cuentas
    request = ListAccountsRequest()
    accounts = client.list_accounts(request=request)

    account_list = list(accounts)
    print(f"\n🔍 Total de cuentas encontradas: {len(account_list)}\n")

    if not account_list:
        print("❌ No se encontraron cuentas. Verifica que:")
        print("   - Tu cuenta de Google tenga acceso a propiedades de Google Analytics")
        print("   - Las APIs estén habilitadas en Google Cloud")
        exit(1)

    all_data = []

    for account_idx, account in enumerate(account_list, 1):
        account_id = account.name.split('/')[-1]
        account_name = account.display_name
        account_create_time = account.create_time

        print(f"\n{'=' * 80}")
        print(f"📍 CUENTA #{account_idx}: {account_name}")
        print(f"{'=' * 80}")
        print(f"   Account ID: {account_id}")
        print(f"   Creada: {account_create_time}")
        print(f"   Estado: {'Activa' if not account.deleted else 'Eliminada'}")

        # Listar propiedades de esta cuenta
        properties = client.list_properties(
            filter_=f'parent:accounts/{account_id}'
        )

        property_list = list(properties)
        print(f"\n   🏠 PROPIEDADES ({len(property_list)}):")

        for prop_idx, prop in enumerate(property_list, 1):
            prop_id = prop.name.split('/')[-1]
            prop_name = prop.display_name
            prop_timezone = prop.time_zone
            currency_code = prop.currency_code
            created = prop.create_time

            print(f"\n      {prop_idx}. {prop_name}")
            print(f"         Property ID: {prop_id}")
            print(f"         URL: https://analytics.google.com/analytics/web/#/a{account_id}p{prop_id}/reports/intelligenthome")
            print(f"         Zona horaria: {prop_timezone}")
            print(f"         Moneda: {currency_code}")
            print(f"         Creada: {created}")

            # Listar datos streams (sitios web/apps)
            data_streams = client.list_data_streams(
                parent=prop.name
            )

            stream_list = list(data_streams)
            if stream_list:
                print(f"         📡 Data Streams ({len(stream_list)}):")
                for stream in stream_list:
                    stream_id = stream.name.split('/')[-1]
                    stream_name = stream.display_name
                    stream_type = stream.type_.name if hasattr(stream.type_, 'name') else str(stream.type_)

                    print(f"            - {stream_name} (ID: {stream_id}, Tipo: {stream_type})")

                    if hasattr(stream, 'web_data_stream') and stream.web_data_stream:
                        web = stream.web_data_stream
                        print(f"              URL: {web.default_uri if hasattr(web, 'default_uri') else 'N/A'}")

                    if hasattr(stream, 'android_app_data_stream') and stream.android_app_data_stream:
                        print(f"              App Android configurada")

                    if hasattr(stream, 'ios_app_data_stream') and stream.ios_app_data_stream:
                        print(f"              App iOS configurada")

            # Guardar datos
            all_data.append({
                'account_id': account_id,
                'account_name': account_name,
                'property_id': prop_id,
                'property_name': prop_name,
                'timezone': prop_timezone,
                'currency': currency_code,
                'streams': len(stream_list)
            })

    # Resumen en tabla
    print(f"\n\n{'=' * 80}")
    print("📋 RESUMEN GENERAL")
    print(f"{'=' * 80}\n")

    print(f"{'Account':<30} {'Property':<30} {'ID':<15} {'Streams':<10}")
    print("-" * 85)

    for data in all_data:
        account_display = data['account_name'][:28]
        property_display = data['property_name'][:28]
        prop_id = data['property_id']
        streams = data['streams']

        print(f"{account_display:<30} {property_display:<30} {prop_id:<15} {streams:<10}")

    print(f"\n✅ Total: {len(account_list)} cuenta(s), {len(all_data)} propiedad(es)")

    # Guardar datos en JSON para referencia
    import json
    output_file = Path.home() / "Desktop/claude/analytics_accounts.json"
    with open(output_file, 'w') as f:
        json.dump(all_data, f, indent=2)
    print(f"\n💾 Datos guardados en: {output_file}")

except Exception as e:
    print(f"\n❌ Error: {e}")
    print(f"\nTipo de error: {type(e).__name__}")
    import traceback
    traceback.print_exc()
