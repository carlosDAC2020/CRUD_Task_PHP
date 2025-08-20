terraform {
  required_providers {
    google = {
      source  = "hashicorp/google"
      version = ">= 4.0.0"
    }
  }
}

provider "google" {
  project = var.gcp_project_id
  region  = var.gcp_region
}

# Recurso para la Máquina Virtual
resource "google_compute_instance" "app_server" {
  name         = "php-app-vm"
  machine_type = "e2-medium" # Un poco más grande para correr la BD y la app
  zone         = "${var.gcp_region}-a"

  boot_disk {
    initialize_params {
      # Usamos una imagen optimizada para contenedores que ya incluye Docker
      image = "cos-cloud/cos-stable"
    }
  }

  network_interface {
    network = "default"
    access_config {} # Asigna una IP externa
  }

  # Script que se ejecuta al iniciar la VM para instalar Docker Compose
  metadata_startup_script = <<-EOF
    #!/bin/bash
    # La imagen COS ya tiene Docker, solo necesitamos Docker Compose
    sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
  EOF

  tags = ["http-server"]
}

# Recurso para la regla de Firewall
resource "google_compute_firewall" "allow_http" {
  name    = "allow-app-http"
  network = "default"
  allow {
    protocol = "tcp"
    ports    = ["8080"] # Solo abrimos el puerto de nuestra aplicación
  }
  target_tags = ["http-server"]
  source_ranges = ["0.0.0.0/0"] # Permite tráfico desde cualquier IP
}

# Output para saber la IP pública de la VM
output "instance_public_ip" {
  value = google_compute_instance.app_server.network_interface[0].access_config[0].nat_ip
}