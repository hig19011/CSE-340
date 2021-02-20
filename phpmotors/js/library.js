const passwordButton = document.querySelector("#passwordButton");
if(passwordButton != null) {
  passwordButton.addEventListener("click", ()=> {
    let passwordInput = document.getElementById("clientPassword");
    let type = passwordInput.getAttribute("type");
    if(type == "password") {
      passwordInput.setAttribute("type", "text");
      passwordButton.innerHTML = "Hide Password";    
    } else {
      passwordInput.setAttribute("type", "password");
      passwordButton.innerHTML = "Show Password";    
    }
  });
}
