document.addEventListener("DOMContentLoaded",function(){let l=document.getElementById("drop-area"),s=document.getElementById("fileElem"),u=document.getElementById("file-name"),i=document.getElementById("preview-container"),r=document.getElementById("reselect-btn");document.getElementById("toukou-btn");let c=!1;["dragenter","dragover","dragleave","drop"].forEach(e=>{l.addEventListener(e,h,!1),document.body.addEventListener(e,h,!1)}),l.addEventListener("drop",E,!1),s.addEventListener("change",g,!1),r.addEventListener("click",function(){L(),s.value="",c=!1,l.style.display="block",r.style.display="none"});function h(e){e.preventDefault(),e.stopPropagation()}function E(e){let n=e.dataTransfer.files;g({target:{files:n}})}function g(e){let t=e.target.files;if(t.length>0){const n=t[0];u.innerText=n.name,w(n),c=!0}}function w(e){for(;i.firstChild;)i.removeChild(i.firstChild);if(e.type.startsWith("image/")){let t=new FileReader;t.readAsDataURL(e),t.onloadend=function(){let n=document.createElement("img");n.src=t.result,n.classList.add("preview"),i.appendChild(n),n.onload=function(){const o=document.createElement("canvas"),C=o.getContext("2d"),f=800,m=600;let a=n.width,d=n.height;a>d?a>f&&(d*=f/a,a=f):d>m&&(a*=m/d,d=m),o.width=a,o.height=d,C.drawImage(n,0,0,a,d),o.toBlob(function(v){const b=new File([v],e.name,{type:e.type,lastModified:Date.now()}),y=new DataTransfer;y.items.add(b),s.files=y.files;const p=document.createElement("img");p.src=URL.createObjectURL(v),p.classList.add("preview"),i.innerHTML="",i.appendChild(p),l.style.display="none",r.style.display="block"},"image/jpeg",.75)}}}else if(e.type.startsWith("video/")){const t=document.createElement("video");t.src=URL.createObjectURL(e),t.controls=!0,t.classList.add("preview"),i.appendChild(t),l.style.display="none",r.style.display="block"}}function L(){for(;i.firstChild;)i.removeChild(i.firstChild);u.innerText=""}document.querySelector("form").addEventListener("submit",function(e){c||(s.value="",e.target.appendChild(new FormData().append("img_path","public/img/dfo.jpg")))})});