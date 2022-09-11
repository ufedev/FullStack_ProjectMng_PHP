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
