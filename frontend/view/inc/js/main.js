function ajaxPromise(sUrl, sType, sTData, sData = undefined) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData
        }).done((data) => {
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            reject(errorThrow);
        }); 
    });
}

/*==================== FRIENDLY URL ====================*/
function friendlyURL(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for (var i=0; i<url.length; i++) {
    	cont++;
        var aux = url[i].split("=");
        if (cont == 2) {
        	link +=  "/"+aux[1]+"/";	
        }else{
        	link +=  "/"+aux[1];
        }
    }
    return "http://localhost/Concesionario_Framwork" + link;
}
/*==================== LOAD MENU ====================*/
function load_menu() {
    $('<div></div>').attr('class',"navbar-nav mr-auto").appendTo(".navbar-nav").html( 
        '<a href="index.php?module=home&op=view" class="nav-item nav-link">Home</a>'+
        '<a href="index.php?module=shop&op=view" class="nav-item nav-link">shop</a>'+
        '<a href="index.php?module=contact&op=view" class="nav-item nav-link">Contact</a>'
    )
    var token = localStorage.getItem('token');
    if(token != null) {
        ajaxPromise('index.php?module=login&op=data_user', 
        'POST', 'JSON', {token: token})
        .then(function(data) {
            if (data[0].type_user === 'admin') {
                menu_admin();
            }else if (data[0].type_user === 'client') {
                menu_client();
            }
        }).catch(function() {});
    }
    $('<div></div>').attr('class',"ml-auto").appendTo(".ml-auto").html( 
        '<a class="btn btn-custom" href="index.php?module=login&op=view_login">Login</a>'
    )
}

/*==================== MENUS ====================*/
function menu_admin() {
    $(".ml-auto").empty();
    $('<div></div>').attr('class',"ml-auto").appendTo(".ml-auto").html( 
        '<a class="btn btn-custom" id="logout" href="">Log out</a>'
    )

    //$('<div></div>').attr('class',"").appendTo(".ml-auto").html(
    //    '<div class="circular--portrait">'+
    //    '<img src="'+data.avatar_user+'" style = "max-width: 100%; max-height: 50px;"/>'+
    //    '</div>'
    //)
}

function menu_client() {
    $(".ml-auto").empty();
    $('<div></div>').attr('class',"ml-auto").appendTo(".ml-auto").html( 
        '<a class="btn btn-custom" id="logout" href="">Log out</a>'
    )

    //$('<div></div>').attr('class',"").appendTo(".perfil").html(
    //    '<div class="circular--portrait">'+
    //    '<img src="'+data.avatar_user+'" style = "max-width: 100%; max-height: 50px;"/>'+
    //    '</div>'
    //)
}

/*==================== CLICK LOGOUT ====================*/
function click_logout() {
    $(document).on('click', '#logout', function() {
        logout();
    });
}

/*==================== LOGOUT ====================*/
function logout() {
    ajaxPromise('index.php?module=login&op=logout', 
    'POST', 'JSON')
    .then(function(data) {
        localStorage.removeItem('token');
        var zone = localStorage.getItem('zone');
        if (zone == 'shop') {
            setTimeout('window.location.href = "index.php?module=shop&op=view"; ',200);
        } else {
            setTimeout('window.location.href = "index.php?module=home&op=view"; ',200);
        }
    }).catch(function() {
        console.log('error_logout');
    });
}

function logout_control() {
    localStorage.removeItem('token');
    window.location.href ="index.php?module=login&op=view_login";
}

$(document).ready(function() {
    load_menu();
    click_logout();
});