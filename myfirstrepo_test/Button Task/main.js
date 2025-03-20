document.getElementById("btnexample").addEventListener("click", e=>{
    console.log("Click event triggered");

    
    const xhttp = new XMLHttpRequest();

    xhttp.addEventListener("load", e => {
        const modules = JSON.parse(e.target.responseText);
    
        let output = "";
        modules.forEach(module => {
            output += "<p>Name: " + module.name + ", Leader: " + module.leader + "</p>";
        });
    
        document.getElementById("result").innerHTML = output;
    });
    
    xhttp.open("GET", "modules.json");
    xhttp.send();
    
});

