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

document.addEventListener("DOMContentLoaded", async () => {
  buscarColaborador()
  obtenerColaborador()
  eliminarColaborador()
})

function buscarColaborador() {
  //seleccionamos el boton
  const btn = document.querySelector("#nuevo_colaborador")
  //seleccionamos el modal
  const modal = document.querySelector("#modal_colaborador")
  if (btn && modal) {
    btn.addEventListener("click", () => {
      modal.classList.remove("modal_hidden")
      const divBusqueda = document.querySelector(
        "#modal_colaborador #lista_busqueda_colaborador"
      )

      if (divBusqueda) {
        if (divBusqueda.lastChild) {
          divBusqueda.removeChild(divBusqueda.lastChild)
        }
      }
    })
    modal.addEventListener("click", (e) => {
      if (e.target.classList.contains("modal")) {
        modal.classList.add("modal_hidden")
      }
    })
  }

  //abrimos el modal
}

function obtenerColaborador() {
  //seleccionamos el form

  const form = document.querySelector("#modal_colaborador #modal_form")
  if (form) {
    form.addEventListener("submit", handleBuscarColaborador)
  }
}

async function handleBuscarColaborador(e) {
  e.preventDefault()

  const email = document.querySelector("#modal_colaborador #buscar_colaborador")

  try {
    const req = await fetch(`${URL_FRONT}/colaboradores`, {
      method: "POST",
      body: JSON.stringify({ email: email.value }),
    })
    const res = await req.json()
    formatearResultados(res)
    email.value = ""
  } catch (e) {
    console.log(e)
  }
}

function formatearResultados(resultados) {
  const divBusqueda = document.querySelector(
    "#modal_colaborador #lista_busqueda_colaborador"
  )

  if (divBusqueda) {
    if (divBusqueda.lastChild) {
      divBusqueda.removeChild(divBusqueda.lastChild)
    }
    if (resultados?.email) {
      const button = document.createElement("button")
      const email = document.createElement("p")
      const nombre = document.createElement("span")
      email.textContent = resultados.email
      nombre.textContent = resultados.nombre

      button.appendChild(nombre)
      button.appendChild(email)

      button.addEventListener("click", () =>
        agregarColaborador(resultados.email)
      )
      divBusqueda.appendChild(button)
    } else {
      const notFound = document.createElement("p")
      notFound.textContent = resultados
      divBusqueda.appendChild(notFound)
    }
  }
}

async function agregarColaborador(email_colaborador) {
  try {
    const req = await fetch(`${window.location.href}`, {
      method: "PUT",
      body: JSON.stringify({ email: email_colaborador }),
    })
    const res = await req.json()

    mostrarAlerta(res)
    if (res === "Agregado...") {
      setTimeout(() => window.location.reload(), 1500)
    }
  } catch (e) {
    console.log(e)
  }
}

function mostrarAlerta(alerta) {
  const div = document.querySelector(
    "#modal_colaborador #alerta_modal_colaborador"
  )

  if (div) {
    if (div.lastChild) {
      div.removeChild(div.lastChild)
    }

    const p = document.createElement("p")
    p.textContent = alerta

    div.appendChild(p)
    setTimeout(() => {
      div.removeChild(div.lastChild)
    }, 3000)
  }
}

function eliminarColaborador() {
  const btn = document.querySelectorAll("#eliminar_colaborador")
  if (btn) {
    btn.forEach((b) => {
      b.addEventListener("click", async (e) => {
        const confirmar = confirm(
          "Esta seguro que desea quitar este colaborador"
        )

        if (!confirmar) {
          return
        }
        try {
          const req = await fetch(
            `${URL_FRONT}/colaboradores/${b.dataset["colaborador"]}`,
            {
              method: "DELETE",
            }
          )
          const res = await req.json()

          if (res) {
            window.location.reload()
          }
        } catch (e) {}
      })
    })
  }
}

document.addEventListener("DOMContentLoaded", () => {
  eliminarProyecto()
})

const eliminarProyecto = () => {
  const btn = document.querySelector("#eliminar_proyecto")
  if (btn) {
    btn.addEventListener("click", handleEliminarProyecto)
  }
}

const handleEliminarProyecto = async (e) => {
  const confirmar = confirm(
    "Seguro desea eliminar este Proyecto? perdera todos los datos"
  )
  if (!confirmar) return
  const url = window.location.href

  try {
    const req = await fetch(url, {
      method: "DELETE",
    })
    const res = await req.json()
    if (res) {
      window.location.reload()
    }
  } catch (e) {}
}

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

const URL_TAREAS = "http://uptask.host/tareas"
const URL_FRONT = "http://uptask.host"
