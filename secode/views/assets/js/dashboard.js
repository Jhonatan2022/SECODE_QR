/* _     
  (_)___ 
  | / __|
  | \__ \
 _/ |___/
|__/     
*/

//variables 
let btnOptions = document.querySelector(".OptionsCodeQr");
let contOptions = document.querySelector(".cont-optionsCode");
var closeWindow;

//funcion para abrir el modal de opciones
btnOptions.addEventListener("click", () => {
  console.log('ok')
  contOptions.style.opacity = "1";
  contOptions.style.visibility = "visible";
  closeWindow = true;
  //confirmar si se cierra la ventana sin guardar los cambios
  if (closeWindow) {
    window.onbeforeunload = () => {
      return "¿Estas seguro de que quieres salir?";
    };
  }
});

let iconClose = document.querySelector(".icon-close");

//funcion para cerrar el modal de opciones
iconClose.addEventListener("click", () => {
  contOptions.style.opacity = "0";
  contOptions.style.visibility = "hidden";

  if (closeWindow) {
    window.onbeforeunload = () => {
      return window.close();
    };
  }
});
