<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/shoppingCart.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <!-- Embed the template file Content ID -->
    <div id="app"></div>
    <div id="temporaryContent">
        <div class="listProduct">
            Content file index
        </div>
    </div>
    <button id="displayList" onclick="window.location.href='php/display_cookies.php'">Display Cookies List</button>
    
    <!-- Phoo Parts -->
    <div class="content-container">
        <div class="review">
            <div class="title"><b>Latest Reviews</b></div>
            <div class="latestReviews" id="latestReviews"></div>
            <div class="reviewcontent">
                <form id="reviewForm" action="php/shoppingcart.php" method="post">
                    <div class="input-box">
                        <label for="Email">Email</label>
                        <input required type="text" name="Email" class="Email">
                    </div>
                    <div class="input-box">
                        <label for="Content">Review</label>
                        <textarea required name="Content" class="Content"></textarea>
                    </div>
                    <div class="input-box">
                        <label for="Rating">Stars</label>
                        <input required type="number" name="Rating" min="1" max="5">
                    </div>
                    <div class="button">
                        <input type="submit" name="submit">
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Restaurant Info -->
        <div class="restaurant-photo">
            <img src="images/he&she.jpg" alt="hnscafe photo">
            <div class="info-text">
                <h3>He & She Cafe</h3>
                <h3>Address: He & She Coffee UPM, Persiaran Tulang Daing Seri Kembangan, 43400 Serdang, Selangor</h3>
                <h3>Instagram: <a target="_blank" href="https://www.instagram.com/heandshecoffeeupm/">heandshecoffeeupm</a></h3>
                <h3>Phone: 019-3923019</h3>
            </div>
        </div>
    </div>
    
    <!-- mouse trailer -->
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    
    <script src="js/shoppingCart.js" type="module"></script>
    <!-- JavaScript for Displaying Reviews -->
    <script>
        function fetchReviews() {
            fetch('php/shoppingcart.php') // Adjust URL as per your PHP script for fetching reviews
            .then(response => response.json())
            .then(data => {
                let reviewContainer = document.getElementById('latestReviews');
                reviewContainer.innerHTML = ''; // Clear previous content
                data.forEach(review => {
                    let newReview = document.createElement('div');
                    newReview.className = 'reviewContent';
                    newReview.innerHTML = `
                    <p>
                        ${review['Content']} <br>
                        <strong>${review['Email']} Says:</strong><br>
                        Giving ${review['Rating']} stars
                    </p>
                    `;
                    reviewContainer.appendChild(newReview);
                });
            })
            .catch(error => console.error('Error fetching reviews:', error));
        }
        
        fetchReviews();
    </script>
</body>

</html>