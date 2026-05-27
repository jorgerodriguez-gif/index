#!/usr/bin/env python3
"""
Automatiza la configuración de Google Analytics MCP
"""
import json
import os
from pathlib import Path

def create_analytics_config():
    """Crea la configuración de Google Analytics MCP para Claude Code"""

    print("=" * 60)
    print("🔧 Configurador Google Analytics MCP")
    print("=" * 60)

    # Datos que ya conocemos
    print("\n📊 Información de tu Google Analytics:")
    account_id = "1725851"
    property_id = "358743188"
    print(f"  Account ID: {account_id}")
    print(f"  Property ID: {property_id}")

    # Crear credenciales básicas
    credentials_path = Path.home() / ".config/gcloud/application_default_credentials.json"

    print("\n🔑 Pasos siguientes:")
    print("\n1. Ve a: https://console.cloud.google.com/apis/credentials")
    print("2. Crea un nuevo OAuth 2.0 Client ID (tipo: Desktop app)")
    print("3. Descarga el JSON")
    print(f"4. Guarda en: {credentials_path}")

    print("\n5. Luego ejecuta:")
    print(f"   gcloud auth application-default login")

    print("\n✨ Una vez completado, podrás:")
    print("   - Consultar datos de tus propiedades de Google Analytics")
    print("   - Integrar con Claude Code para análisis automático")
    print("   - Crear reportes personalizados")

if __name__ == "__main__":
    create_analytics_config()
