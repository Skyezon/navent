const province = document.getElementById("province");

const getCities = () => {
    let result = document.getElementById("city");
    const query = document.getElementById("province");
    fetch(`http://localhost:8000/event/location?province=${query.value}`, {
        method: "GET"
    })
        .then(e => e.json())
        .then(function(res) {
            console.log(res);
            for (var i = 0; i < res.length; i++) {
                if (i === 0) {
                    result.innerHTML = "";
                }
                const r = res[i];
                console.log(r);
                result.innerHTML += `
                     <option value="${r}">${r}</option>
                    `;
            }
        });
};
