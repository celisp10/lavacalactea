const inputs = document.querySelectorAll("input");
const selects = document.querySelectorAll("select");
const form = document.getElementById("form");
const alerts = document.getElementById("alerts");
const containerModal = document.querySelector(".container-modal");
const modal = document.querySelector(".modal");
const openModal = document.getElementById("open-modal");
const closeModal = document.querySelector(".close-modal");
const body = document.querySelector("body");
const indexOption = document.querySelectorAll(".option");
const liquidationOptions = document.querySelectorAll(".liquidation_options a");

indexOption.forEach(option => {
    if(!option.classList.contains("operator") && !option.classList.contains("administrator")) {
        option.style.display = 'none';
    }
})

liquidationOptions.forEach(option => {
    if(!option.classList.contains("operator") && !option.classList.contains("administrator")) {
        option.style.display = 'none';
    }
})


// Formularios

function validateInput(e) {
    if(e.target.classList.contains("no-use")) {
        return;
    } else if(e.target.value.trim() === "" || e.target.value.trim() === null) {
        e.target.style.border = "2px solid red";
    } else {
        e.target.style.border = "2px solid green";
    }
}

let quantityErrors = 0;

function message(message) {

    if(quantityErrors === 0) {

        quantityErrors = 1;

        let paragraph = document.createElement("P");
        paragraph.classList.add("btn");
        paragraph.style.background = "red";
        paragraph.textContent = message;
    
        alerts.appendChild(paragraph);
    
        setTimeout(() => {
            paragraph.remove();
            quantityErrors = 0;
        }, 3000)
    }

}

form.addEventListener("submit", (e) => {

    let inputValid = true;
    let selectValid = true;

    inputs.forEach(input => {
        if(input.classList.contains("no-use")) {
            console.log("No se usa");
            return;
        } else if(input.value.trim() === "" || input.value.trim() === null) {
            e.preventDefault();
            inputValid = false;
        }
    });

    selects.forEach(select => {
        if(select.value.trim() === "" || select.value.trim() === null) {
            e.preventDefault();
            selectValid = false;
        }
    })


    if(!inputValid || !selectValid) {
        message("Todos los campos son obligatorios");
    }

})

inputsValid = inputs.forEach(function(input) {
    input.addEventListener("input", validateInput);
});

selects.forEach(function(select) {
    select.addEventListener("change", validateInput);
})

// Modal

openModal.addEventListener("click", (e) => {
    containerModal.style.display = "flex";
    modal.style.display = "flex";
    body.style.overflow = "hidden";
})

closeModal.addEventListener("click", (e) => {
    containerModal.style.display = "none";
    modal.style.display = "none";
    body.style.overflow = "visible";
})