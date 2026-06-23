document.addEventListener("DOMContentLoaded", function () {

    const confirmForms = document.querySelectorAll("form[data-confirm]");
    const searchInput = document.getElementById("searchInput");
    const productGrid = document.getElementById("productGrid");
    const wishlistBox = document.getElementById("wishlistItems");
    const categoryLinks = document.querySelectorAll(".category-filter .filter-btn");

    confirmForms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            const message = form.dataset.confirm || "Are you sure?";

            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const productCards = document.querySelectorAll(".product-grid .product-card");

            let visibleCount = 0;

            productCards.forEach(function (card) {
                const productName = card.getAttribute("data-product-name")
                    ? card.getAttribute("data-product-name").toLowerCase()
                    : "";

                const isVisible = searchTerm === "" || productName.includes(searchTerm);

                card.style.display = isVisible ? "block" : "none";

                if (isVisible) {
                    visibleCount++;
                }
            });

            if (visibleCount === 0 && searchTerm) {
                showNoResultsMessage("No products match your search.");
            } else {
                removeNoResultsMessage();
            }
        });
    }

    categoryLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            const href = this.getAttribute("href");

            if (href) {
                window.location.href = href;
            }
        });
    });

    if (wishlistBox) {
        renderWishlistItems();
    }

    function showNoResultsMessage(message) {
        if (!productGrid) return;

        let noResults = productGrid.querySelector(".no-results");

        if (!noResults) {
            noResults = document.createElement("div");
            noResults.className = "no-results";
            productGrid.appendChild(noResults);
        }

        noResults.textContent = message;
    }

    function removeNoResultsMessage() {
        if (!productGrid) return;

        const noResults = productGrid.querySelector(".no-results");

        if (noResults) {
            noResults.remove();
        }
    }

    function renderWishlistItems() {
        let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

        if (wishlist.length === 0) {
            wishlistBox.innerHTML = "<p>No wishlist items yet.</p>";
            return;
        }

        wishlistBox.innerHTML = wishlist.map(function (item) {
            return `
                <div class="product-card">
                    <img src="assets/images/products/${item.image}" style="width:100%; height:220px; object-fit:cover;">
                    <div class="product-card-body">
                        <h3>${item.name}</h3>
                        <button type="button" class="button" onclick="removeWishlist('${item.id}')">
                            Remove
                        </button>
                    </div>
                </div>
            `;
        }).join("");
    }

    window.removeWishlist = function (id) {
        let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

        wishlist = wishlist.filter(function (item) {
            return item.id !== id;
        });

        localStorage.setItem("wishlist", JSON.stringify(wishlist));

        renderWishlistItems();
    };
});

/* Wishlist Add */

function addToWishlist(id, name, image) {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    const exists = wishlist.some(function (item) {
        return item.id === id;
    });

    if (!exists) {
        wishlist.push({
            id: id,
            name: name,
            image: image
        });

        localStorage.setItem("wishlist", JSON.stringify(wishlist));
    }
}

/* Offer Popup - Show only once per browser session */

window.addEventListener("load", function () {

    if (!sessionStorage.getItem("offerShown")) {

        setTimeout(function () {
            const popup = document.getElementById("offerPopup");

            if (popup) {
                popup.style.display = "flex";
                sessionStorage.setItem("offerShown", "yes");
            }
        }, 1200);
    }
});

function closeOfferPopup() {
    const popup = document.getElementById("offerPopup");

    if (popup) {
        popup.style.display = "none";
    }
}

/* Product Quick View */

function openQuickView(name, price, image, category) {
    document.getElementById("quickName").innerText = name;
    document.getElementById("quickPrice").innerText = "₹" + price;
    document.getElementById("quickCategory").innerText = category;

    document.getElementById("quickImage").src =
        "/shree_mohan/ShreeMohanSweets/assets/images/products/" + image;

    document.getElementById("quickViewPopup").style.display = "flex";
}

function closeQuickView() {
    document.getElementById("quickViewPopup").style.display = "none";
}

/* Festival Slider */

let festivalIndex = 0;
const festivalSlides = document.querySelectorAll(".festival-slide");

if (festivalSlides.length > 0) {
    setInterval(function () {
        festivalSlides[festivalIndex].classList.remove("active");

        festivalIndex = (festivalIndex + 1) % festivalSlides.length;

        festivalSlides[festivalIndex].classList.add("active");
    }, 4000);
}