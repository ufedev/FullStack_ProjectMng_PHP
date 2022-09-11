document.addEventListener("DOMContentLoaded", () => {
  nuevaTarea()
  editarTarea()
  eliminarTarea()
  changeState()
})

let tarea = {}
const setTarea = (task) => {
  tarea = task
}

const nuevaTarea = () => {
  const btnNuevaTarea = document.querySelector("#nueva_tarea")
  const modalNuevaTarea = document.querySelector("#modal")
  const formModal = document.querySelector("#modal_form")
  if (btnNuevaTarea && modalNuevaTarea) {
    btnNuevaTarea.addEventListener("click", async (e) => {
      handleClickBtn(e, modalNuevaTarea)
      modalNuevaTarea.addEventListener("click", handleClickOutModal)
      setTarea({})
      if (!tarea.id) {
        formModal.removeEventListener("submit", handleUpdate)
        formModal.addEventListener("submit", handleSubmit)
      }
    })
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
    alerta("Todos los campos son obligatorios", "error", "#alerta_modal")
    return
  }
  setTarea({ nombre, descripcion, entrega, prioridad, proyecto })

  try {
    const req = await fetch(URL_TAREAS, {
      "Content-Type": "application/json",
      method: "POST",
      body: JSON.stringify(tarea),
    })
    const res = await req.json()

    alerta(res.msg, res.type, "#alerta_modal")

    if (res.type == "exito") {
      setTimeout(() => window.location.reload(), 1500)
    }
  } catch (e) {}
}

const editarTarea = () => {
  const btnEditarTarea = document.querySelectorAll(".tareas #editar_tarea")
  const modalEditarTarea = document.querySelector("#modal_editar")
  const formModal = document.querySelector("#modal_form_editar")

  if (btnEditarTarea.length > 0) {
    btnEditarTarea.forEach((button) => {
      if (modalEditarTarea) {
        button.addEventListener("click", async (e) => {
          handleClickBtn(e, modalEditarTarea)
          modalEditarTarea.addEventListener("click", handleClickOutModal)
          await obtenerTarea(e.target.dataset["tarea"])
          await setterInputs(tarea, "#modal_form_editar")
          formModal.addEventListener("submit", handleUpdate)
        })
      }
    })
  }
}

const obtenerTarea = async (id_tarea = null) => {
  try {
    const req = await fetch(`${URL_TAREAS}/${id_tarea}`)
    const res = await req.json()
    setTarea(res)
  } catch (error) {}
}
const setterInputs = async (task, id_fth) => {
  const nombre = document.querySelector(`${id_fth} #nombre`)
  const descripcion = document.querySelector(`${id_fth} #descripcion`)
  const entrega = document.querySelector(`${id_fth} #entrega`)
  const prioridad = document.querySelector(`${id_fth} #prioridad`)

  nombre.value = task.nombre
  descripcion.value = task.descripcion
  entrega.value = task.entrega
  prioridad.value = task.prioridad
}

const handleUpdate = async (e) => {
  e.preventDefault()
  const nombre = document.querySelector("#modal_form_editar #nombre").value
  const descripcion = document.querySelector(
    "#modal_form_editar #descripcion"
  ).value
  const entrega = document.querySelector("#modal_form_editar #entrega").value
  const prioridad = document.querySelector(
    "#modal_form_editar #prioridad"
  ).value
  if ([nombre, descripcion, entrega, prioridad].includes("")) {
    alerta("Todos los campos son obligatorios", "error", "#alerta_modal_editar")
    return
  }
  setTarea({ ...tarea, nombre, descripcion, entrega, prioridad })

  try {
    const req = await fetch(`${URL_TAREAS}`, {
      method: "PUT",
      body: JSON.stringify(tarea),
    })

    const res = await req.json()
    alerta(res.msg, res.type, "#alerta_modal_editar")
    if (res.type === "exito") {
      setTimeout(() => {
        window.location.reload()
      }, 1500)
    }
  } catch {}
}

//Eliminar

const eliminarTarea = () => {
  const tareas = document.querySelectorAll(".tareas #eliminar_tarea")
  tareas.forEach((task) => {
    task.addEventListener("click", handleDelete)
  })
}
const handleDelete = async (e) => {
  e.preventDefault()
  const confirmar = confirm("Esta segur@ de eliminar esta tarea?")
  if (!confirmar) {
    return
  }
  try {
    const task_id = e.target.dataset["tarea"]
    const req = await fetch(`${URL_TAREAS}/${task_id}`, {
      method: "DELETE",
    })
    const res = await req.json()
    if (res) {
      window.location.reload()
    }
  } catch (e) {}
}

//cambiar estado COMPLETA - INCOMPLETA

const changeState = () => {
  const btnEstados = document.querySelectorAll(".tareas #completar_tarea")
  btnEstados.forEach((state) => {
    state.addEventListener("click", handleChangeState)
  })
}
const handleChangeState = async (e) => {
  e.preventDefault()
  const task = e.target.dataset["tarea"]
  try {
    const req = await fetch(`${URL_TAREAS}/${task}`, {
      method: "PUT",
    })
    const res = await req.json()
    if (res) {
      window.location.reload()
    }
  } catch (error) {}
}
