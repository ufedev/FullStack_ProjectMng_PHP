document.addEventListener("DOMContentLoaded", async () => {
  await obtenerProyectos()
  buscar()
})

let Proyectos = []
const setProyectos = (data) => {
  Proyectos = data
}
function buscar() {
  const btn = document.querySelector("#search_button")
  const modal = document.querySelector("#modal_buscar")
  const datalist = document.querySelector("#lista_proyectos")
  const form = document.querySelector("#modal_buscar #modal_form")
  form.addEventListener("submit", (e) => {
    e.preventDefault()
    const input = document.querySelector("#modal_buscar #buscar_proyecto").value
    const project = Proyectos.find(
      (p) => p.proyecto.toLowerCase() === input.toLowerCase()
    )
    if (project) {
      window.location.href = `${URL_FRONT}/proyectos/${project.token}`
    }
  })
  if (datalist) {
    Proyectos.forEach((proj) => {
      const option = document.createElement("option")
      option.value = proj.proyecto

      datalist.appendChild(option)
    })
  }

  if (modal && btn) {
    btn.addEventListener("click", (e) => openModal(e, modal))
    modal.addEventListener("click", closeModal)
  }
}

const openModal = (e, modal) => {
  modal.classList.toggle("modal_hidden")
}

const closeModal = (e) => {
  if (e.target.id === "modal_buscar") {
    e.target.classList.add("modal_hidden")
  }
}

const obtenerProyectos = async () => {
  const url = `${URL_FRONT}/obtener-proyectos`

  try {
    const req = await fetch(url)
    const res = await req.json()
    setProyectos(res)
  } catch (e) {}
}
