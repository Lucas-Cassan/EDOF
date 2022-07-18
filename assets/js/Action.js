console.log("JS ACTION OK");
const controller_name = document.getElementById("main").getAttribute("class");

if (controller_name == "Ajouter une action") {
  console.log("JS ACTION READY");

  function counterAction(title) {
    console.log(title);
    const Input = document.getElementById("action_" + title);
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
  //ACTION DE FORMATION COUNTER
  counterAction("numero");
  counterAction("conditionsSpecifiques");
  counterAction("urlWeb");
  counterAction("restauration");
  counterAction("hebergement");
  counterAction("transport");
  counterAction("modalitesRecrutement");
  counterAction("modalitesPedagogiques");
  counterAction("infosPerimetreRecrutement");
  counterAction("nombreHeuresCentre");
  counterAction("nombreHeuresEntreprise");

  //EXTRAS
  counterAction("modalitesHandicap");
  counterAction("infoAdmission");
  counterAction("fraisAnpec");
  counterAction("detailFraisAnpec");
  counterAction("autresServices");
  counterAction("fraisHt");
  counterAction("fraisTtc");
}
