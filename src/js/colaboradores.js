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
