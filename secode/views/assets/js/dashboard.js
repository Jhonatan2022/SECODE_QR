let btnOptions = document.querySelector('#OptionsCodeQr');
let contOptions = document.querySelector('#cont-optionsCode');

btnOptions.addEventListener('click',()=>{
    
    //contOptions.style.display='block';
    contOptions.style.opacity='1';
    contOptions.style.visibility='visible';
})

let iconClose = document.querySelector('.icon-close');

iconClose.addEventListener('click',()=>{
    contOptions.style.opacity='0';
    contOptions.style.visibility='hidden';
})