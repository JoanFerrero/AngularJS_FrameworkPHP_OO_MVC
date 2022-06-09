app.controller('controller_home', function($scope, carousel, categoria, type, books) {

    var books_array = [];
    var books_array1 = [];
    var books_array2 = [];
    var objects = 4;
    
    $scope.brands = carousel;
    $scope.categorias = categoria;
    $scope.types = type;
    
    localStorage.setItem('zone', 'home');

    $scope.redirect_shop = function () {
        var filters = [];
        try {
            filters.push(['id_brand', this.brand.id_brand]);
        } catch (error) {}

        try {
            filters.push(['id_category', this.categoria.id_category]);
        } catch (error) {}

        try {
            filters.push(['id_type', this.type.id_type]);
        } catch (error) {}
        
        localStorage.setItem('filters_home', JSON.stringify(filters)); 
        location.href = "#/shop";
    }

    books.items.forEach(books => {
        if (books.volumeInfo) {
            const const_books = {
                'title': books.volumeInfo.title,
                'thumbnail': books.volumeInfo.imageLinks.thumbnail,
            }
            books_array.push(const_books);
        }
    });

    $scope.more_news = function() {
        objects = 8;
        if(books_array) {
            for (let i = 0; i < objects; i++) {
                books_array2.push(books_array[i]);
            }   
        }
        $scope.show_MoteBooks = false;
        $scope.books_scope = books_array2;
    }

    if(books_array) {
        $scope.show_MoteBooks = true;
        for (let i = 0; i < objects; i++) {
            books_array1.push(books_array[i]);
        }   
    }

    $scope.books_scope = books_array1;
});