let categories=document.querySelectorAll(".cat-pill");
let menucard=document.querySelectorAll(".menu-card");
let count=document.querySelector("#menuCount");
let links=document.querySelectorAll(".nav-link");
categories.forEach((category)=>{
    category.addEventListener("click",()=>{
        categories.forEach((cat)=>{
            cat.classList.remove("active");
        })
        category.classList.add("active");
        let visible=0;
        
        menucard.forEach((card)=>{
            if(category.dataset.cat==="all" || category.dataset.cat===card.dataset.cat ){
                card.style.display="";
                visible++;
                
            }
            else{
                card.style.display="none";
                
            }
        })
        count.textContent=visible;
    })
})

links.forEach((link)=>{
    link.addEventListener("click",()=>{
        links.forEach((li)=>{
            li.classList.remove("active");
        })
        link.classList.add("active");
    })
})

