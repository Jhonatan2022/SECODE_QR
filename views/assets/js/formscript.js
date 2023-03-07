<<<<<<< HEAD
let tl = gsap.timeline({ease:'power1.in'})
 let __SplitText = new SplitText("#text", {type:"words,chars"})
 let clicked = false
let chars = __SplitText.chars


document.querySelector('#button').addEventListener('click',()=>{
  if(clicked === false){
    clicked = true
    tl.to(chars, {duration: 0.5,opacity:0, scale:0, y:80, rotationX:180, transformOrigin:"0% 50% -50",   stagger: 0.1,repeat:0})
  tl.to('#button',{width:'50px',duration:0.5})
  tl.to('#w',{y:'0%',duration:0.5})
  }
  else if(clicked === true){
    clicked = false
      tl.to('#w',{y:'100%',duration:0.5})
      tl.to('#button',{width:'135px',duration:0.5})
tl.to(chars, {duration: 0.5, opacity:1, scale:1, y:0, rotationX:0, transformOrigin:"0% 50% -50", stagger: 0.1,repeat:0})
  }



=======
let tl = gsap.timeline({ease:'power1.in'})
 let __SplitText = new SplitText("#text", {type:"words,chars"})
 let clicked = false
let chars = __SplitText.chars


document.querySelector('#button').addEventListener('click',()=>{
  if(clicked === false){
    clicked = true
    tl.to(chars, {duration: 0.5,opacity:0, scale:0, y:80, rotationX:180, transformOrigin:"0% 50% -50",   stagger: 0.1,repeat:0})
  tl.to('#button',{width:'50px',duration:0.5})
  tl.to('#w',{y:'0%',duration:0.5})
  }
  else if(clicked === true){
    clicked = false
      tl.to('#w',{y:'100%',duration:0.5})
      tl.to('#button',{width:'135px',duration:0.5})
tl.to(chars, {duration: 0.5, opacity:1, scale:1, y:0, rotationX:0, transformOrigin:"0% 50% -50", stagger: 0.1,repeat:0})
  }



>>>>>>> withpays
})