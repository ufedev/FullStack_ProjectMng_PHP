document.addEventListener("DOMContentLoaded", () => {})

function alerta(msg, type) {
  const alerta = document.querySelector("#alerta_modal")

  while (alerta.lastChild) {
    alerta.removeChild(alerta.lastChild)
  }
  if (alerta) {
    const mensaje = document.createElement("p")
    mensaje.classList.add("alerta")
    mensaje.classList.add(type)
    mensaje.textContent = `${msg}`
    alerta.appendChild(mensaje)
    setTimeout(() => alerta.removeChild(mensaje), 3000)
  }
}
