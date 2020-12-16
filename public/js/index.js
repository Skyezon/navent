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

function searchProduct() {
    const query = document.getElementById("product-search").value;
    let result = document.getElementById("result");
    setTimeout(function() {
        fetch(`http://localhost:8000/product/search?query=${query}`, {
            method: "GET"
        })
            .then(e => e.json())
            .then(res => {
                result.innerHTML = "";
                if (res.message === "Not Found" && query.length !== 0) {
                    result.innerHTML = `
                    <div class="not-found">
                        <div class="not-found-title">Not Found</div>
                        <img src="/assets/not-found.svg"></img>
                        <div class="not-found-desc">Looks like the product you searched not found, try another one</div>
                    </div>`;
                } else {
                    for (var i = 0; i < res.length; i++) {
                        if (i === 0) {
                            result.innerHTML = "";
                        }
                        const r = res[i];
                        result.innerHTML += `
                    <div class="item-container">
                        <a href="/product/${r.id}/detail" class="item d-flex flex-direction-row">
                            <img class="item-image" src="${r.image}"></img>
                            <div class="item-detail">
                                <div class="item-title">${r.name}</div>
                                <div class="item-price">Rp.${r.price}</div>
                            </div>
                        </a>
                    </div>
                    `;
                    }
                }
            });
    }, 300);
}

function searchEvent() {
    const query = document.getElementById("product-search").value;
    let result = document.getElementById("result");
    setTimeout(function() {
        fetch(`http://localhost:8000/event/search?query=${query}`, {
            method: "GET"
        })
            .then(e => e.json())
            .then(res => {
                result.innerHTML = "";
                if (res.message === "Not Found" && query.length !== 0) {
                    result.innerHTML = `
                    <div class="not-found">
                        <div class="not-found-title">Not Found</div>
                        <img src="/assets/not-found.svg"></img>
                        <div class="not-found-desc">Looks like the product you searched not found, try another one</div>
                    </div>`;
                } else {
                    for (var i = 0; i < res.length; i++) {
                        if (i === 0) {
                            result.innerHTML = "";
                        }
                        const r = res[i];
                        result.innerHTML += `
                    <div class="item-container">
                        <a href="/event/${r.id}/detail" class="item d-flex flex-direction-row">
                            <img class="item-image" src="${r.image}"></img>
                            <div class="item-detail">
                                <div class="item-title">${r.name}</div>
                                <div class="item-price">Rp.${r.price}</div>
                            </div>
                        </a>
                    </div>
                    `;
                    }
                }
            });
    }, 300);
}

const changeProductType = () => {
    const id = document.getElementById("productType").value;
    window.location = "http://localhost:8000/products?type_id=" + id;
};

const changeEventType = () => {
    const id = document.getElementById("eventType").value;
    window.location = "http://localhost:8000/event?type_id=" + id;
};
