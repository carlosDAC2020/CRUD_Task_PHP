variable "gcp_project_id" {
  description = "El ID del proyecto de GCP."
  type        = string
}

variable "gcp_region" {
  description = "La región para desplegar los recursos."
  type        = string
  default     = "us-central1"
}