document.addEventListener("DOMContentLoaded", () => {
  nuevaTarea()
})

const nuevaTarea = () => {
  const btnNuevaTarea = document.querySelector("#nueva_tarea")
  const modalNuevaTarea = document.querySelector("#modal")
  const formModal = document.querySelector("#modal_form")
  if (btnNuevaTarea && modalNuevaTarea) {
    btnNuevaTarea.addEventListener("click", (e) =>
      handleClickBtn(e, modalNuevaTarea)
    )

    modalNuevaTarea.addEventListener("click", handleClickOutModal)
    formModal.addEventListener("submit", handleSubmit)
  }
}

const handleClickBtn = (e, modal) => {
  modal.classList.toggle("modal_hidden")
}
const handleClickOutModal = (e) => {
  if (e.target.classList.value === "modal") {
    e.target.classList.add("modal_hidden")
  }
}

const handleSubmit = async (e) => {
  e.preventDefault()

  const nombre = document.querySelector("#modal_form #nombre").value
  const descripcion = document.querySelector("#modal_form #descripcion").value
  const entrega = document.querySelector("#modal_form #entrega").value
  const prioridad = document.querySelector("#modal_form #prioridad").value
  const proyecto = document.querySelector("#modal_form #proyecto").value
  if ([nombre, descripcion, entrega, prioridad].includes("")) {
    alerta("Todos los campos son obligatorios", "error")
    return
  }
  const tarea = {
    nombre,
    descripcion,
    entrega,
    prioridad,
    proyecto,
  }
  try {
    const req = await fetch(URL_TAREAS, {
      "Content-Type": "application/json",
      method: "POST",
      body: JSON.stringify(tarea),
    })
    const res = await req.json()

    alerta(res.msg, res.type)

    if (res.type == "exito") {
      setTimeout(() => window.location.reload(), 1500)
    }
  } catch (e) {}
}
