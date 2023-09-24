//variables
var btnOptions = document.querySelector(".OptionsCodeQr");
var contOptions = document.querySelector(".cont-optionsCode");
var closeWindow;

//funcion para abrir el modal de opciones
btnOptions.addEventListener("click", () => {
  console.log("ok");
  contOptions.style.opacity = "1";
  contOptions.style.visibility = "visible";
});

var iconClose = document.querySelector(".icon-close");

//funcion para cerrar el modal de opciones
iconClose.addEventListener("click", () => {
  contOptions.style.opacity = "0";
  contOptions.style.visibility = "hidden";
});
var BtnSendFormClinic = document.querySelector("#BtnSendFormClinic");