  const pageModifiee = document.getElementById("pageChoisie");
  const choix = document.getElementById("choix");
  document.getElementById("pageChoisie").addEventListener("click", (e2) => {
    let fin = true;
    for(let i=0; i<pageModifiee.options.length; i++){
      if(i != pageModifiee.selectedIndex && pageModifiee.options[i].text.includes(pageModifiee.options[pageModifiee.selectedIndex].text) && pageModifiee.options[pageModifiee.selectedIndex].text.length < 8){
        fin = false;
      }
    }
    console.log(fin);
    if(fin){
      document.getElementById("choix1").style.display = "none";
      document.getElementById("choix2").style.display = "none";
      document.getElementById("choix3").style.display = "none";
    }
    else{
      document.getElementById("choix1").style.display = "block";
      document.getElementById("choix2").style.display = "block";
      document.getElementById("choix3").style.display = "block";
    }
  });