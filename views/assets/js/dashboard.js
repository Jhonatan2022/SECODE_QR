/* _     
  (_)___ 
  | / __|
  | \__ \
 _/ |___/
|__/     
*/

//variables
var btnOptions = document.querySelector('.OptionsCodeQr');
var contOptions = document.querySelector('.cont-optionsCode');
var closeWindow;

//funcion para abrir el modal de opciones
btnOptions.addEventListener('click', () => {
  console.log('ok');
  contOptions.style.opacity = '1';
  contOptions.style.visibility = 'visible';
  //closeWindow = true;
  //confirmar si se cierra la ventana sin guardar los cambios

  /* if (closeWindow) {
    window.onbeforeunload = () => {
      return '¿Estas seguro de que quieres salir?';
    };
  } */
});

var iconClose = document.querySelector('.icon-close');

//funcion para cerrar el modal de opciones
iconClose.addEventListener('click', () => {
  contOptions.style.opacity = '0';
  contOptions.style.visibility = 'hidden';

  /* if (closeWindow) {
    window.onbeforeunload = () => {
      return window.close();
    };
  } */
});

//no close while pdf generate in clinico.php

//variables
var BtnSendFormClinic = document.querySelector('#BtnSendFormClinic');

//funcion para abrir el modal de opciones
BtnSendFormClinic.addEventListener('click', () => {
  //confirmar si se cierra la ventana sin guardar los cambios

  /* if (closeWindow) {
    window.onbeforeunload = () => {
      return '¿Estas seguro de que quieres salir?';
    };
  } */
});
