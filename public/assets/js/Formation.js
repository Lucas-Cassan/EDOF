console.log("JS FORMATION OK");
const controller_name = document.getElementById("main").getAttribute("class");

if (controller_name == "Ajouter une formation") {
  console.log("JS FORMATION READY");

  function counterFormation(title) {
    console.log(title);
    const Input = document.getElementById("formation_" + title);
    const Counter = document.getElementById(title + "Counter");
    const MaxLength = Input.getAttribute("maxlength");
    Counter.innerHTML = MaxLength + " / " + MaxLength;

    Input.addEventListener("input", (event) => {
      const valueLength = event.target.value.length;
      const leftCharLength = MaxLength - valueLength;

      if (leftCharLength < 0) return;
      Counter.innerHTML = leftCharLength + " / " + MaxLength;
    });
  }

  //FORMATION COUNTER
  counterFormation("numero");
  counterFormation("intituleFormation");
  counterFormation("objectifFormation");
  counterFormation("resultatsAttendus");
  counterFormation("contenuFormation");
  counterFormation("certifInfo");
  counterFormation("extraResumeContenu");
}
