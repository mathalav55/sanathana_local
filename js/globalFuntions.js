const phoneRegEx =  /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
const emailRegEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
const countryCodes = {
    "countries": [
      {
        "code": "+91",
        "name": "India"
      },
      {
        "code": "+7840",
        "name": "Abkhazia"
      },
      {
        "code": "+93",
        "name": "Afghanistan"
      },
      {
        "code": "+355",
        "name": "Albania"
      },
      {
        "code": "+213",
        "name": "Algeria"
      },
      {
        "code": "+1684",
        "name": "American Samoa"
      },
      {
        "code": "+376",
        "name": "Andorra"
      },
      {
        "code": "+244",
        "name": "Angola"
      },
      {
        "code": "+1264",
        "name": "Anguilla"
      },
      {
        "code": "+1268",
        "name": "Antigua and Barbuda"
      },
      {
        "code": "+54",
        "name": "Argentina"
      },
      {
        "code": "+374",
        "name": "Armenia"
      },
      {
        "code": "+297",
        "name": "Aruba"
      },
      {
        "code": "+247",
        "name": "Ascension"
      },
      {
        "code": "+61",
        "name": "Australia"
      },
      {
        "code": "+672",
        "name": "Australian External Territories"
      },
      {
        "code": "+43",
        "name": "Austria"
      },
      {
        "code": "+994",
        "name": "Azerbaijan"
      },
      {
        "code": "+1242",
        "name": "Bahamas"
      },
      {
        "code": "+973",
        "name": "Bahrain"
      },
      {
        "code": "+880",
        "name": "Bangladesh"
      },
      {
        "code": "+1246",
        "name": "Barbados"
      },
      {
        "code": "+1268",
        "name": "Barbuda"
      },
      {
        "code": "+375",
        "name": "Belarus"
      },
      {
        "code": "+32",
        "name": "Belgium"
      },
      {
        "code": "+501",
        "name": "Belize"
      },
      {
        "code": "+229",
        "name": "Benin"
      },
      {
        "code": "+1441",
        "name": "Bermuda"
      },
      {
        "code": "+975",
        "name": "Bhutan"
      },
      {
        "code": "+591",
        "name": "Bolivia"
      },
      {
        "code": "+387",
        "name": "Bosnia and Herzegovina"
      },
      {
        "code": "+267",
        "name": "Botswana"
      },
      {
        "code": "+55",
        "name": "Brazil"
      },
      {
        "code": "+246",
        "name": "British Indian Ocean Territory"
      },
      {
        "code": "+1284",
        "name": "British Virgin Islands"
      },
      {
        "code": "+673",
        "name": "Brunei"
      },
      {
        "code": "+359",
        "name": "Bulgaria"
      },
      {
        "code": "+226",
        "name": "Burkina Faso"
      },
      {
        "code": "+257",
        "name": "Burundi"
      },
      {
        "code": "+855",
        "name": "Cambodia"
      },
      {
        "code": "+237",
        "name": "Cameroon"
      },
      {
        "code": "+1",
        "name": "Canada"
      },
      {
        "code": "+238",
        "name": "Cape Verde"
      },
      {
        "code": "+ 345",
        "name": "Cayman Islands"
      },
      {
        "code": "+236",
        "name": "Central African Republic"
      },
      {
        "code": "+235",
        "name": "Chad"
      },
      {
        "code": "+56",
        "name": "Chile"
      },
      {
        "code": "+86",
        "name": "China"
      },
      {
        "code": "+61",
        "name": "Christmas Island"
      },
      {
        "code": "+61",
        "name": "Cocos-Keeling Islands"
      },
      {
        "code": "+57",
        "name": "Colombia"
      },
      {
        "code": "+269",
        "name": "Comoros"
      },
      {
        "code": "+242",
        "name": "Congo"
      },
      {
        "code": "+243",
        "name": "Congo, Dem. Rep. of (Zaire)"
      },
      {
        "code": "+682",
        "name": "Cook Islands"
      },
      {
        "code": "+506",
        "name": "Costa Rica"
      },
      {
        "code": "+385",
        "name": "Croatia"
      },
      {
        "code": "+53",
        "name": "Cuba"
      },
      {
        "code": "+599",
        "name": "Curacao"
      },
      {
        "code": "+537",
        "name": "Cyprus"
      },
      {
        "code": "+420",
        "name": "Czech Republic"
      },
      {
        "code": "+45",
        "name": "Denmark"
      },
      {
        "code": "+246",
        "name": "Diego Garcia"
      },
      {
        "code": "+253",
        "name": "Djibouti"
      },
      {
        "code": "+1767",
        "name": "Dominica"
      },
      {
        "code": "+1809",
        "name": "Dominican Republic"
      },
      {
        "code": "+670",
        "name": "East Timor"
      },
      {
        "code": "+56",
        "name": "Easter Island"
      },
      {
        "code": "+593",
        "name": "Ecuador"
      },
      {
        "code": "+20",
        "name": "Egypt"
      },
      {
        "code": "+503",
        "name": "El Salvador"
      },
      {
        "code": "+240",
        "name": "Equatorial Guinea"
      },
      {
        "code": "+291",
        "name": "Eritrea"
      },
      {
        "code": "+372",
        "name": "Estonia"
      },
      {
        "code": "+251",
        "name": "Ethiopia"
      },
      {
        "code": "+500",
        "name": "Falkland Islands"
      },
      {
        "code": "+298",
        "name": "Faroe Islands"
      },
      {
        "code": "+679",
        "name": "Fiji"
      },
      {
        "code": "+358",
        "name": "Finland"
      },
      {
        "code": "+33",
        "name": "France"
      },
      {
        "code": "+596",
        "name": "French Antilles"
      },
      {
        "code": "+594",
        "name": "French Guiana"
      },
      {
        "code": "+689",
        "name": "French Polynesia"
      },
      {
        "code": "+241",
        "name": "Gabon"
      },
      {
        "code": "+220",
        "name": "Gambia"
      },
      {
        "code": "+995",
        "name": "Georgia"
      },
      {
        "code": "+49",
        "name": "Germany"
      },
      {
        "code": "+233",
        "name": "Ghana"
      },
      {
        "code": "+350",
        "name": "Gibraltar"
      },
      {
        "code": "+30",
        "name": "Greece"
      },
      {
        "code": "+299",
        "name": "Greenland"
      },
      {
        "code": "+1473",
        "name": "Grenada"
      },
      {
        "code": "+590",
        "name": "Guadeloupe"
      },
      {
        "code": "+1671",
        "name": "Guam"
      },
      {
        "code": "+502",
        "name": "Guatemala"
      },
      {
        "code": "+224",
        "name": "Guinea"
      },
      {
        "code": "+245",
        "name": "Guinea-Bissau"
      },
      {
        "code": "+595",
        "name": "Guyana"
      },
      {
        "code": "+509",
        "name": "Haiti"
      },
      {
        "code": "+504",
        "name": "Honduras"
      },
      {
        "code": "+852",
        "name": "Hong Kong SAR China"
      },
      {
        "code": "+36",
        "name": "Hungary"
      },
      {
        "code": "+354",
        "name": "Iceland"
      },
      {
        "code": "+62",
        "name": "Indonesia"
      },
      {
        "code": "+98",
        "name": "Iran"
      },
      {
        "code": "+964",
        "name": "Iraq"
      },
      {
        "code": "+353",
        "name": "Ireland"
      },
      {
        "code": "+972",
        "name": "Israel"
      },
      {
        "code": "+39",
        "name": "Italy"
      },
      {
        "code": "+225",
        "name": "Ivory Coast"
      },
      {
        "code": "+1876",
        "name": "Jamaica"
      },
      {
        "code": "+81",
        "name": "Japan"
      },
      {
        "code": "+962",
        "name": "Jordan"
      },
      {
        "code": "+77",
        "name": "Kazakhstan"
      },
      {
        "code": "+254",
        "name": "Kenya"
      },
      {
        "code": "+686",
        "name": "Kiribati"
      },
      {
        "code": "+965",
        "name": "Kuwait"
      },
      {
        "code": "+996",
        "name": "Kyrgyzstan"
      },
      {
        "code": "+856",
        "name": "Laos"
      },
      {
        "code": "+371",
        "name": "Latvia"
      },
      {
        "code": "+961",
        "name": "Lebanon"
      },
      {
        "code": "+266",
        "name": "Lesotho"
      },
      {
        "code": "+231",
        "name": "Liberia"
      },
      {
        "code": "+218",
        "name": "Libya"
      },
      {
        "code": "+423",
        "name": "Liechtenstein"
      },
      {
        "code": "+370",
        "name": "Lithuania"
      },
      {
        "code": "+352",
        "name": "Luxembourg"
      },
      {
        "code": "+853",
        "name": "Macau SAR China"
      },
      {
        "code": "+389",
        "name": "Macedonia"
      },
      {
        "code": "+261",
        "name": "Madagascar"
      },
      {
        "code": "+265",
        "name": "Malawi"
      },
      {
        "code": "+60",
        "name": "Malaysia"
      },
      {
        "code": "+960",
        "name": "Maldives"
      },
      {
        "code": "+223",
        "name": "Mali"
      },
      {
        "code": "+356",
        "name": "Malta"
      },
      {
        "code": "+692",
        "name": "Marshall Islands"
      },
      {
        "code": "+596",
        "name": "Martinique"
      },
      {
        "code": "+222",
        "name": "Mauritania"
      },
      {
        "code": "+230",
        "name": "Mauritius"
      },
      {
        "code": "+262",
        "name": "Mayotte"
      },
      {
        "code": "+52",
        "name": "Mexico"
      },
      {
        "code": "+691",
        "name": "Micronesia"
      },
      {
        "code": "+1808",
        "name": "Midway Island"
      },
      {
        "code": "+373",
        "name": "Moldova"
      },
      {
        "code": "+377",
        "name": "Monaco"
      },
      {
        "code": "+976",
        "name": "Mongolia"
      },
      {
        "code": "+382",
        "name": "Montenegro"
      },
      {
        "code": "+1664",
        "name": "Montserrat"
      },
      {
        "code": "+212",
        "name": "Morocco"
      },
      {
        "code": "+95",
        "name": "Myanmar"
      },
      {
        "code": "+264",
        "name": "Namibia"
      },
      {
        "code": "+674",
        "name": "Nauru"
      },
      {
        "code": "+977",
        "name": "Nepal"
      },
      {
        "code": "+31",
        "name": "Netherlands"
      },
      {
        "code": "+599",
        "name": "Netherlands Antilles"
      },
      {
        "code": "+1869",
        "name": "Nevis"
      },
      {
        "code": "+687",
        "name": "New Caledonia"
      },
      {
        "code": "+64",
        "name": "New Zealand"
      },
      {
        "code": "+505",
        "name": "Nicaragua"
      },
      {
        "code": "+227",
        "name": "Niger"
      },
      {
        "code": "+234",
        "name": "Nigeria"
      },
      {
        "code": "+683",
        "name": "Niue"
      },
      {
        "code": "+672",
        "name": "Norfolk Island"
      },
      {
        "code": "+850",
        "name": "North Korea"
      },
      {
        "code": "+1670",
        "name": "Northern Mariana Islands"
      },
      {
        "code": "+47",
        "name": "Norway"
      },
      {
        "code": "+968",
        "name": "Oman"
      },
      {
        "code": "+92",
        "name": "Pakistan"
      },
      {
        "code": "+680",
        "name": "Palau"
      },
      {
        "code": "+970",
        "name": "Palestinian Territory"
      },
      {
        "code": "+507",
        "name": "Panama"
      },
      {
        "code": "+675",
        "name": "Papua New Guinea"
      },
      {
        "code": "+595",
        "name": "Paraguay"
      },
      {
        "code": "+51",
        "name": "Peru"
      },
      {
        "code": "+63",
        "name": "Philippines"
      },
      {
        "code": "+48",
        "name": "Poland"
      },
      {
        "code": "+351",
        "name": "Portugal"
      },
      {
        "code": "+1787",
        "name": "Puerto Rico"
      },
      {
        "code": "+974",
        "name": "Qatar"
      },
      {
        "code": "+262",
        "name": "Reunion"
      },
      {
        "code": "+40",
        "name": "Romania"
      },
      {
        "code": "+7",
        "name": "Russia"
      },
      {
        "code": "+250",
        "name": "Rwanda"
      },
      {
        "code": "+685",
        "name": "Samoa"
      },
      {
        "code": "+378",
        "name": "San Marino"
      },
      {
        "code": "+966",
        "name": "Saudi Arabia"
      },
      {
        "code": "+221",
        "name": "Senegal"
      },
      {
        "code": "+381",
        "name": "Serbia"
      },
      {
        "code": "+248",
        "name": "Seychelles"
      },
      {
        "code": "+232",
        "name": "Sierra Leone"
      },
      {
        "code": "+65",
        "name": "Singapore"
      },
      {
        "code": "+421",
        "name": "Slovakia"
      },
      {
        "code": "+386",
        "name": "Slovenia"
      },
      {
        "code": "+677",
        "name": "Solomon Islands"
      },
      {
        "code": "+27",
        "name": "South Africa"
      },
      {
        "code": "+500",
        "name": "South Georgia and the South Sandwich Islands"
      },
      {
        "code": "+82",
        "name": "South Korea"
      },
      {
        "code": "+34",
        "name": "Spain"
      },
      {
        "code": "+94",
        "name": "Sri Lanka"
      },
      {
        "code": "+249",
        "name": "Sudan"
      },
      {
        "code": "+597",
        "name": "Suriname"
      },
      {
        "code": "+268",
        "name": "Swaziland"
      },
      {
        "code": "+46",
        "name": "Sweden"
      },
      {
        "code": "+41",
        "name": "Switzerland"
      },
      {
        "code": "+963",
        "name": "Syria"
      },
      {
        "code": "+886",
        "name": "Taiwan"
      },
      {
        "code": "+992",
        "name": "Tajikistan"
      },
      {
        "code": "+255",
        "name": "Tanzania"
      },
      {
        "code": "+66",
        "name": "Thailand"
      },
      {
        "code": "+670",
        "name": "Timor Leste"
      },
      {
        "code": "+228",
        "name": "Togo"
      },
      {
        "code": "+690",
        "name": "Tokelau"
      },
      {
        "code": "+676",
        "name": "Tonga"
      },
      {
        "code": "+1868",
        "name": "Trinidad and Tobago"
      },
      {
        "code": "+216",
        "name": "Tunisia"
      },
      {
        "code": "+90",
        "name": "Turkey"
      },
      {
        "code": "+993",
        "name": "Turkmenistan"
      },
      {
        "code": "+1649",
        "name": "Turks and Caicos Islands"
      },
      {
        "code": "+688",
        "name": "Tuvalu"
      },
      {
        "code": "+1340",
        "name": "U.S. Virgin Islands"
      },
      {
        "code": "+256",
        "name": "Uganda"
      },
      {
        "code": "+380",
        "name": "Ukraine"
      },
      {
        "code": "+971",
        "name": "United Arab Emirates"
      },
      {
        "code": "+44",
        "name": "United Kingdom"
      },
      {
        "code": "+1",
        "name": "United States"
      },
      {
        "code": "+598",
        "name": "Uruguay"
      },
      {
        "code": "+998",
        "name": "Uzbekistan"
      },
      {
        "code": "+678",
        "name": "Vanuatu"
      },
      {
        "code": "+58",
        "name": "Venezuela"
      },
      {
        "code": "+84",
        "name": "Vietnam"
      },
      {
        "code": "+1808",
        "name": "Wake Island"
      },
      {
        "code": "+681",
        "name": "Wallis and Futuna"
      },
      {
        "code": "+967",
        "name": "Yemen"
      },
      {
        "code": "+260",
        "name": "Zambia"
      },
      {
        "code": "+255",
        "name": "Zanzibar"
      },
      {
        "code": "+263",
        "name": "Zimbabwe"
      }
    ]
  };  
function showError(element,message){
    var parentNode = element.parentNode;
    element.classList.add('is-invalid');
    var errorELement = document.createElement('span');
    errorELement.setAttribute('class', 'error');
    errorELement.setAttribute('style' , 'color : #f00');
    errorELement.innerText = message;
    if(parentNode.querySelectorAll('.error').length == 0){
        parentNode.appendChild(errorELement);
    }
    
}
function removeError(element){
    var parentNode = element.parentNode;
    if(parentNode.querySelectorAll('.error').length > 0){
        element.classList.remove('is-invalid');
        var errorELement = parentNode.querySelector('.error');
        parentNode.removeChild(errorELement);
    }  
}
async function emptyState(section,pageName){
    var myheaders = new Headers();
    console.log(pageName);
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
        console.log(result);
        console.log(section);
        var image = section.querySelector('#emptyImage');
        console.log(image);
        image.setAttribute('src',result[0].	emptystateimg);
        return section;
    }
    catch(error){
        console.log(error);
        return null;
    }
}

function noConnection(){
    //if no connection redirect to this page
    window.location="../../UI/pages/emptyPage.html";
}

function validateEmail(value){
    if(validate(value)){
        if(value.match(emailRegEx)) 
            return true;
        else    
            return false;
    }
    return false;
}
function validatePhone(value){
    if(validate(value)){
        if(value.match(phoneRegEx))
            return true;
        else    
            return false;
    }
    return false;
}
function validate(value){
    if(value.length > 0){
        return true;
    }
    return false;
}
function auth(...args){
    if(args.length == 0){
      sessionStorage.clear();
    }
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
    console.log(result);
    try{
        userData = result;
        onlyAdmin(userData);
    }
    catch(error){
        console.log(error);
    }
    if(result.status === "Not Logged In"){
        //redirect to login screen
        window.open("./login.html","_self");
    }else if(result.status === "Logged In"){
            userData.admin = parseInt(userData.admin);
            if(args[0]=="admin" && result.admin != 1){
                window.open("./dashboard.html","_self");
            }
            // onlyAdmin();
            loadProfile(userData);
            loadNavItems(userData);
            
    }
    })
    .catch(error =>{console.log(error);});
 }
 function countrycodes(){
    console.log("called country codes")
    var countryCodeElement = document.getElementById('countryCode'); 
    var result = countryCodes.countries;        
    result.forEach(item =>{
        var option = document.createElement('option');
        option.setAttribute('value',item.code);
        option.innerText = item.name;
        countryCodeElement.appendChild(option);
    })   
    var code = document.getElementById('countryCode');  
    code.addEventListener('change' , ()=>{
        console.log(code.value);
    });
      
}
 function loadProfile(userData){
    console.log(userData);
    var data = {
      load : "loadbynumber",
      id : userData.memberId
    }
    data = JSON.stringify(data);
    var requestOptions = {
      method : "POST",
      headers : myHeaders,
      redirect : "follow",
      body : data
    }

    fetch('../../ws/Memberprofile.php',requestOptions)
    .then(response => response.json())
    .then(result => {
      console.log(result);
      userData = Array.from(result)[0];
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
                                                  <span class="user-name text-white">`+userData.Name+`</span>
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
    }).catch(error=>{console.log(error)})
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
        
        
        document.getElementById("Tnavlist").innerHTML = navhtml;
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
                <a href="javascipt:void(0)" id="toast-close" onclick="remove(this)">
                    <i class="col bx bx-sm bx-x-circle text-white"  ></i>
                </a>
            </div>
            <div class="row card-body p-1">
                `+message+`
            </div>
        </div>`;
    // document.querySelector('.toast-container').innerHTML = "";
    document.querySelector('.toast-container').appendChild(toastParent.firstElementChild);
    setTimeout(() => {
        var item = document.querySelector('.toast-container').firstElementChild;
        document.querySelector('.toast-container').removeChild(item);
    }, 5000);
}