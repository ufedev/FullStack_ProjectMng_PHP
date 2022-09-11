document.addEventListener("DOMContentLoaded", () => {
  // setTimeout(() => {
  //   window.location.reload()
  // }, 5000)
})

function alerta(msg, type, modal) {
  const alerta = document.querySelector(`${modal}`)

  if (alerta) {
    const divAlerta = document.querySelector(`${modal} .alerta`)
    if (divAlerta) {
      alerta.removeChild(divAlerta)
    }

    const mensaje = document.createElement("p")
    mensaje.classList.add("alerta")
    mensaje.classList.add(type)
    mensaje.textContent = `${msg}`
    alerta.appendChild(mensaje)
    setTimeout(() => alerta.removeChild(mensaje), 3000)
  }
}
