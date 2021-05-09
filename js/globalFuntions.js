async function emptyState(section,pageName){
    var myheaders = new Headers();
    //console.log(pageName);
    //show empty state div and hide the rest of the content
    var emptyData = {
        load : "loadbyname",
        id : pageName
    }
    emptyData = JSON.stringify(emptyData);
    var emptyRequestOptions = {
        method : "POST",
        redirect : "follow",
        headers : myheaders,
        body : emptyData
    }
    try{
        var result = await fetch("../../ws/Accessconfig.php",emptyRequestOptions)
        .then(response => response.json());
        //console.log(result);
        //console.log(section);
        var image = section.querySelector('#emptyImage');
        //console.log(image);
        image.setAttribute('src',result[0].	emptystateimg);
        return section;
    }
    catch(error){
        //console.log(error);
        return null;
    }
}

function noConnection(){
    //if no connection redirect to this page
    window.location="../../UI/pages/emptyPage.html";
}

function auth(){
    var userData = {};
    var authRequestOptions = {
    method : "POST",
    redirect : "follow",
    headers : myHeaders,
    body : ""
    }
    fetch("../../ws/auth.php",authRequestOptions)
    .then(response => response.json())
    .then(result => {
    //console.log(result);
    try{
        userData = result;
        onlyAdmin(userData);
    }
    catch(error){
        //console.log(error);
    }
    if(result.status === "Not Logged In"){
        //redirect to login screen
        window.open("./login.html","_self");
    }else{
            userData.admin = parseInt(userData.admin);
            // if(userData.admin == 0){
            //     window.open("http://localhost/sea_dev/ui/admin/dashBoard.html","_self");
            // }
            // onlyAdmin();
            loadProfile(userData);
            loadNavItems(userData);
            
    }
    })
    .catch(error =>{//console.log(error);});
 }
 async function countrycodes(){
     console.log("called country codes")
    var result = await fetch('../../js/countrycodes.json').then(response => response.json());
    result = result.countries;
    var countryCodes = document.getElementById('countryCode');         
    result.forEach(item =>{
        var option = document.createElement('option');
        option.setAttribute('value',item.code);
        option.innerText = item.name;
        countryCodes.appendChild(option);
    })   
    var code = document.getElementById('countryCode');  
    code.addEventListener('change' , ()=>{
        console.log(code.value);
    });
      
}
 function loadProfile(userData){
    console.log(userData);
    var profileContainer = document.getElementById('profileContainer');
    if(userData.photo === ""){
        if(userData.gender === "Male")
            userData.photo = "../../images/emptystates/male.png";
        else
            userData.photo = "../../emptystates/female.png";
    }
    profileContainer.innerHTML = `<li class="dropdown dropdown-user nav-item">
                                    <a class="" href="javascript:void(0);" data-toggle="dropdown">
                                        <div class="row align-items-center">
                                            <div class="user-nav d-sm-flex d-none">
                                                <span class="user-name text-white">`+userData.name+`</span>
                                            </div>
                                            <div class="div p-1"></div>
                                            <span>
                                                <img class="round" src="`+userData.photo+`" alt="avatar" height="40" width="40">
                                            </span>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right pb-0">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-power-off mr-50"></i>
                                            <span onclick="logOut()"> Logout</span>
                                        </a> 
                                    </div>
                                </li>`;
}
function loadNavItems(userData){
    var rawMenu = "{\"load\":\"loadbyparent\",\"id\":\"Menu\"} ";
    var requestOptionsMenu = {
    method: 'POST',
    headers: myHeaders,
    redirect: 'follow',
    body : rawMenu
    };
    

    fetch("../../ws/Accessconfig.php ", requestOptionsMenu)
    .then(response => response.json())
    .then(result => {
        const navData =  result;
        console.log(navData);
        var navhtml = '';
        for (var i in navData) {
                if(userData.admin == 0){
                    if(navData[i].ContentName === "Admin"){
                        continue;
                    }
                }
                if(navData[i].status == 0){
                    continue;
                }
                navhtml = navhtml + `<li class="nav-item active">
                            <a class="nav-link " href="`+navData[i].urlredirection+`">` + navData[i].ContentName + `</a>
                        </li>`;
        }
        
        
        document.getElementById("Tnavlist ").innerHTML = navhtml;
    })
    .catch(error => console.log('error', error));
}
function logOut(){
    console.log('logout intiated');
    
    var logoutRequestOptions = {
        method : "POST",
        redirect : "follow",
        headers  : myHeaders,
        body : ""
    };
    fetch("../../ws/logout.php",logoutRequestOptions)
    .then(response => response.json())
    .then(result => {
        console.log(result);
        //redirect to home page
        window.open("../","_self");
        })
    .catch(error =>{
        console.log(error);
        alert("There was an error loggin you out Please try again")
        });
}
function onlyAdmin(userData){
    console.log(userData);
    console.log("called only admin");
    if(userData.admin != 1){
        console.log("Is Not Admin")
        var items = document.querySelectorAll('.onlyAdmin');
        items = Array.from(items);
        items.forEach(item =>{
            var dummy = document.createElement('div');
            item.parentNode.appendChild(dummy);
            item.parentNode.removeChild(item);
        })
    }
}
function remove(el){
    var toast = el.parentNode.parentNode;
    toast.remove();
}
function toast(message,bg){
    var toastParent = document.createElement('div');
    toastParent.innerHTML = `<div class="col card p-0">
            <div class="row card-header `+bg+`">
                <i class="ficon bx bx-bell bx-tada bx-flip-horizontal text-white"></i>
                <span class="text-white">Message</span>
                <div class="col"></div>
                <div class="col"></div>
                <a href="javascipt:void(0)" onclick="remove(this)">
                    <i class="col bx bx-sm bx-x-circle text-white"  ></i>
                </a>
            </div>
            <div class="row card-body p-1">
                `+message+`
            </div>
        </div>`;
    // document.querySelector('.toast-container').innerHTML = "";
    document.querySelector('.toast-container').appendChild(toastParent.firstElementChild);
}