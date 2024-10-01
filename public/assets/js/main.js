
console.log(document.location.pathname);
var currentPage = 1;
var niz={};
niz.page=currentPage;
var parent_element;
function IspisPaginacije(broj, broj_aktivan) {
    let string_za_ispis = "<ul class=\"pagination\">";
    console.log(broj);

    for (let i = 1; i <= broj; i++) {
        string_za_ispis += `
        <li class="page-item"><a class="page-link ${i == broj_aktivan ? 'djordje_active' : ""}" data-id=${i}>${i}</a></li>`;
    }
    string_za_ispis += `</ul>`;
    document.querySelector('#paginacija').innerHTML = string_za_ispis;
}
if(document.location.pathname=='/cars'){
    var insert_button=document.querySelector('#favouriteButton');
    function IspisiModele(niz,model_id=false) {
        let x = "<option value='0'>Choose</option>";
        for (let element of niz) {
            x += `<option value="${element.id}" ${model_id ? (element.id == model_id ? 'selected' : '') : ''}>${element.name}</option>`;
        }
        document.querySelector('#modeli').removeAttribute('disabled');
        // document.querySelector('#gorivo').removeAttribute('disabled');
        // document.querySelector('#karoserija').removeAttribute('disabled');
        // document.querySelector('#cena_od').removeAttribute('disabled');
        // document.querySelector('#cena_do').removeAttribute('disabled');
        document.querySelector('#modeli').innerHTML = x;
    }
    document.addEventListener('DOMContentLoaded', function () {

        let currentPage = 1;
        let niz = { page: currentPage };

        function debounce(func, delay) {
            let timeoutId;
            return function () {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    func.apply(this, arguments);
                }, delay);
            };
        }

        function fetchData() {
            ProveraFiltera();
            console.log(niz);

            $.ajax({
                url: '/car',
                type: 'GET',
                data: niz,
                success: function (data) {
                    console.log(data);
                    console.log(typeof (data.last_page));
                    IspisPaginacije(data.last_page, data.current_page);
                    IspisAuta(data.data);
                },
                error: function (error) {
                    console.log('Error:', error.responseTextpage);
                }
            });
        }

        function ProveraFiltera() {
            let brand_id = parseInt(document.querySelector('#brend_id').value);
            let model_id = parseInt(document.querySelector('#modeli').value);
            let gorivo_id = parseInt(document.querySelector('#gorivo').value);
            let karoserija_id = parseInt(document.querySelector('#karoserija').value);
            let cena_od = parseInt(document.querySelector('#cena_od').value);
            let cena_do = parseInt(document.querySelector('#cena_do').value);
            let sorting=document.querySelector('#sorting').value;

            niz.brandId = brand_id !== 0 ? brand_id : undefined;
            niz.modelId = (!isNaN(model_id) && model_id !== 0) ? model_id : undefined;
            niz.fuelId = gorivo_id !== 0 ? gorivo_id : undefined;
            niz.body_typeId = karoserija_id !== 0 ? karoserija_id : undefined;
            niz.price_from = (!isNaN(cena_od)) ? cena_od : undefined;
            niz.price_to = (!isNaN(cena_do)) ? cena_do : undefined;
            niz.sorting=sorting!="0"?sorting:undefined

            niz.page = currentPage;
        }


        function OcistiFiltere() {
            for (let prop in niz) {
                if (niz[prop] === undefined || niz[prop] === null) {
                    delete niz[prop];
                }
            }
        }

        document.querySelector('#searchButton').addEventListener('click', debounce(function () {
            currentPage = 1;
            OcistiFiltere();
            fetchData();
        }, 300));

        $(document).on('click', '.pagination li a', function (e) {
            e.preventDefault();
            var page = $(this).data('id');
            currentPage = page;
            niz.page = page;
            fetchData();
            UcitavanjeStraniceZaZvezdice();
            $('html, body').animate({
                scrollTop: $('.featured-cars-content').offset().top
            }, 800);
        });

        document.querySelector("#brend_id").addEventListener('change', function () {
            let selected_item = document.querySelector("#brend_id").value;

            if (selected_item !== "0") {
                $.ajax({
                    url: '/getModel/' + selected_item,
                    method: 'GET',
                    success: function (data) {
                        IspisiModele(data);
                    },
                    error: function (error) {
                        console.error('AJAX error:', error);
                    }
                });


            } else {
                document.querySelector('#modeli').setAttribute('disabled', 'true');
                // document.querySelector('#gorivo').setAttribute('disabled', 'true');
                // document.querySelector('#karoserija').setAttribute('disabled', 'true')
                // document.querySelector('#cena_od').setAttribute('disabled', 'true');
                // document.querySelector('#cena_do').setAttribute('disabled', 'true');
                document.querySelector('#modeli').innerHTML = '';
                // document.querySelector('#karoserija').innerHTML='';
                // document.querySelector('#cena_od').innerHTML='';
                // document.querySelector('#cena_do').innerHTML='';
                // document.querySelector('#gorivo').innerHTML='';

            }
        });

        function IspisAuta(niz) {
            let string_za_ispis = "";
            if (niz.length == 0) {
                string_za_ispis += "<h1>There are no products right now</h1>";
                document.querySelector('#ispis_auta').innerHTML = string_za_ispis;
                return;
            } else {
                let max_auto_price=Math.max(...niz.map(x=>x.broj_kupovina));
                console.log(max_auto_price);
                let string_za_ispis = `<div class="row">`;

                for (let i = 0; i < niz.length; i++) {
                    if (i % 4 === 0 && i !== 0) {
                        // Zatvori prethodni red i otvori novi red svaka četiri elementa
                        string_za_ispis += `</div><div class="row">`;
                    }

                    string_za_ispis += `
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="single-featured-cars">
                    <div class="featured-img-box">`;
                    if(niz[i].old_price!=null){
                        let objekat={};
                        objekat=VratiTextIBoju(niz[i].old_price,niz[i].price);
                        string_za_ispis+=`<span class="badge text-bg-${objekat.boja}">${objekat.text}</span>`
                    }
                        string_za_ispis+=`<div class="featured-cars-img">
                            <a href="/car/${niz[i].id}">
                                <img src='assets/images/cars/${niz[i].image}' alt="cars">
                            </a>
                        </div>
                        <div class="featured-model-info">
                            <p>
                                brand:${niz[i].marka_naziv}
                                <span class="featured-mi-span">model:${niz[i].model_naziv}</span>
                                <span class="featured-mi-span">body:${niz[i].karoserija_naziv}</span>
                                <span class="featured-hp-span">engine:${Math.floor(niz[i].horsepower / 1.36)}KW/${niz[i].horsepower}HP</span>
                               fuel: ${niz[i].gorivo_naziv}
                            </p>
                        </div>
                        <div class="rating">`
                        for(let x=5;x>0;x--){
                            string_za_ispis+=`  <input type="radio" data-id=${niz[i].id}  name=${niz[i].id} id=${niz[i].id+"_"+x} class="radio_rating" value=${x}>
                            <label for=${niz[i].id+"_"+x} title=${x}></label>`
                        }


                  string_za_ispis+=`
                    </div>
                        <p id="ocena" class="text-center"></p>
                    </div>
                    <div class="featured-cars-txt">
                        <h2><a href="#">${niz[i].marka_naziv} ${niz[i].model_naziv} ${niz[i].label != null ? niz[i].label : ""}</a></h2>
                        <del>${niz[i].old_price!=null?"$"+niz[i].old_price:""}</del>
                        <h3>$${niz[i].price}</h3>`;
                       if((max_auto_price>0)&&(niz[i].broj_kupovina===max_auto_price)){
                            string_za_ispis+=`<span class="badge text-bg-success">Best seller</span>`
                       }
                        string_za_ispis+=`<p>${niz[i].description.substring(0,100)+"..."}</p>
                    </div>
                </div>
            </div>`;
                }
                string_za_ispis += `</div>`;
                document.querySelector('#ispis_auta').innerHTML = string_za_ispis;
                UcitavanjeStraniceZaZvezdice();
            }
            function VratiTextIBoju(stara_cena,nova_cena){
                let text={};
                let procenat = ((stara_cena - nova_cena) / stara_cena) * 100;
                console.log(procenat);
                if(procenat>=50){
                    text.text="Shock price";
                    text.boja="danger";
                }
                else if(procenat>30 || procenat<=49){
                    text.text="Great deal";
                    text.boja="warning";
                }
                else{
                    text.text="Good deal";
                    text.boja="success";
                }
                return text;
            }
        }



        fetchData();
        $(window).on('load',function (){
            postavljanjeZvezde();
            UcitavanjeStraniceZaZvezdice();
            function DodajListenere(){
                $('.ucitaj_search').off('click').on('click',function (e){
                    let objekat=$(this).data('ids');
                    document.querySelector('#brend_id').value="";
                    document.querySelector('#modeli').value="";
                    document.querySelector('#gorivo').value="";
                    document.querySelector('#karoserija').value="";
                    document.querySelector('#cena_od').value="";
                    document.querySelector('#cena_do').value="";
                    document.querySelector('#sorting').value="";
                    if(objekat.hasOwnProperty('brend_id')){
                        document.querySelector('#brend_id').value=objekat.brend_id;
                    }
                    else{
                        document.querySelector('#brend_id').value="0";
                    }
                    if(objekat.hasOwnProperty('model_id')){
                        $.ajax({
                            url: '/getModel/' + objekat.brend_id,
                            method: 'GET',
                            success: function (data) {
                                console.log(data);
                                for(let element of data){
                                    if(element.id==objekat.model_id){
                                        IspisiModele(data,objekat.model_id);
                                        break;
                                    }
                                }
                            },
                            error: function (error) {
                                console.error('AJAX error:', error);
                            }
                        })
                        document.querySelector('#modeli').value=objekat.model_id;
                    }
                    else{
                        document.querySelector('#modeli').value="0";
                    }
                    if(objekat.hasOwnProperty('gorivo_id')){
                        document.querySelector('#gorivo').value=objekat.gorivo_id;
                    }
                    else{
                        document.querySelector('#gorivo').value="0";
                    }
                    if(objekat.hasOwnProperty('karoserija_id')){
                        document.querySelector('#karoserija').value=objekat.karoserija_id;
                    }
                    else{
                        document.querySelector('#karoserija').value="0";
                    }
                    if(objekat.hasOwnProperty('cena_od')){
                        document.querySelector('#cena_od').value=objekat.cena_od;
                    }
                    else{
                        document.querySelector('#cena_od').value="";
                    }
                    if(objekat.hasOwnProperty('cena_do')){
                        document.querySelector('#cena_do').value=objekat.cena_do;
                    }
                    else{
                        document.querySelector('#cena_do').value="";
                    }
                    if(objekat.hasOwnProperty('sorting')){
                        document.querySelector('#sorting').value=objekat.sorting;
                    }
                    else{
                        document.querySelector('#sorting').value="0";
                    }
                    $("#exampleModal").modal("hide");

                })
                $('.obrisi_search').off('click').on('click',function (e){
                    let id_za_brisanje=$(this).data('delete_id');
                    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                    $.ajax({
                        url: '/favourites',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data:{
                            id:id_za_brisanje
                        },
                        success: function(data) {
                            IspisiArchivedSearches(data)
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                    function IspisiArchivedSearches(niz){
                        let string_za_ispis="";
                        console.log(niz.length);
                        if(niz.length===0){
                            string_za_ispis+=`<tr><td>No bookmarked searches</td></tr>`
                        }
                        else{
                            for(let element of niz){
                                string_za_ispis+=`<tr>
                            <td>${element.name}</td>
                             <td>
                            ${element.brand_name ?? ''}
                            ${element.model_name ?? ''}
                            ${element.karoserija_name ?? ''}
                            ${element.gorivo_name ?? ''}
                            ${element.search_parameters?.cena_od ?? ''}
                            ${element.search_parameters?.cena_do ?? ''}
                            ${element.search_parameters?.sorting ?? ''}
                            </td>
                             <td>
                                        ${element.date_of_archiving}
                              </td>
                            <td>
                                <button class="ucitaj_search" data-ids='${JSON.stringify(element.search_parameters)}'><i class="fa fa-share" style="color:blue"  aria-hidden="true"></i></button>
                                <button class="obrisi_search" data-delete_id="${element.id}"><i class="fa fa-trash" style="color: red" aria-hidden="true"></i></button>
                            </td>
                            </tr>`;
                            }
                        }
                        document.querySelector('#ispis_tabela').innerHTML=string_za_ispis;
                        DodajListenere();
                    }
                })
            }
            DodajListenere();
        })

       function postavljanjeZvezde(){
           $(document).on('click',function (){
               var stars_rating=document.querySelectorAll(".radio_rating");
               for (let element of stars_rating) {
                   element.addEventListener('click', function () {
                       if (!element.classList.contains('rated')) {
                           console.log(element);

                           let user_id = document.querySelector('#user_id').value;
                           user_id = parseInt(user_id);

                           let car_id = $(this).data('id');
                           car_id = parseInt(car_id);

                           let value = $(this).val();
                           value = parseInt(value);

                           let objekat = {};
                           objekat.user_id = user_id;
                           objekat.car_id = car_id;
                           objekat.rating_stars = value;

                           console.log(objekat);

                           parent_element = element.getAttribute('name');
                           console.log(parent_element);

                           var siblingRadios = document.querySelectorAll('input[name="' + parent_element + '"]');
                           siblingRadios.forEach(function(sibling) {
                               sibling.disabled = true;
                           });

                           element.classList.add('rated');

                           $.ajax({
                               url: '/userRating',
                               type: 'GET',
                               data: objekat,
                               dataType: 'json', // Dodato za eksplicitno navođenje da očekujemo JSON
                               success: function (data) {
                                   console.log('Success:', data);
                                   IspisiProsekiProveri(data);
                               },
                               error: function (error) {
                                   console.log('Error:', error.responseTextpage);
                               }
                           });
                       }
                   });
               }

           })
       }
        function IspisiProsekiProveri(niz){
            if(niz.length>0) {
                for (let i = 0; i < niz.length; i++) {
                    var siblingRadios = document.querySelectorAll('input[name="' + niz[i].vehicle_id + '"]');
                    for (let element of siblingRadios) {
                        element.disabled = true;
                        if (element.value == niz[i].ocena) {
                            element.checked = true;
                            element.parentElement.nextElementSibling.innerText = "Your rating is:" + niz[i].ocena;
                        }
                    }
                }
            }
                else{
                    var stars_rating=document.querySelectorAll(".radio_rating");
                    for(element of stars_rating){
                        stars_rating.disabled=false;
                    }

            }

        }
        function UcitavanjeStraniceZaZvezdice(){
            let user_id = document.querySelector('#user_id').value;
            let objekat={}
            objekat.user_id=user_id;
            $.ajax({
                url: '/userRatingLoad',
                type: 'GET',
                data: objekat,
                dataType: 'json', // Dodato za eksplicitno navođenje da očekujemo JSON
                success: function (data) {
                    console.log('Success:', data);
                    IspisiProsekiProveri(data);
                },
                error: function (error) {
                    console.log('Error:', error.responseTextpage);
                }
            });
        }
        function handleDropdownChange() {
            var brendSelected = $('#brend_id').val();
            var modeliSelected = $('#modeli').val();
            var gorivoSelected = $('#gorivo').val();
            var karoserijaSelected = $('#karoserija').val();
            var cenaOdSelected = $('#cena_od').val();
            var cenaDoSelected = $('#cena_do').val();
            var sortingSelected = $('#sorting').val();
            console.log(brendSelected);
            console.log(modeliSelected);
            console.log(gorivoSelected);
            console.log(karoserijaSelected);
            console.log(cenaOdSelected);
            console.log(cenaDoSelected);

            if (
                (brendSelected === "0") &&
                (modeliSelected === "0" || modeliSelected === null) &&
                (gorivoSelected === "0") &&
                (karoserijaSelected === "0") &&
                (cenaOdSelected === "") &&
                (cenaDoSelected === "") &&
                (sortingSelected === "0")
            ) {
               insert_button.style.display="none";
            } else {
                insert_button.style.display="block";
            }
        }

        $('#brend_id, #modeli, #gorivo, #karoserija, #cena_od, #cena_do, #sorting').on('change', function () {
            handleDropdownChange();
        });
          });

        insert_button.addEventListener('click',function (){
            var objekat={};
            var string_za_ispis="";
                let brend_id=document.querySelector('#brend_id');
                let brend_id_value=brend_id.value

                let model_id=document.querySelector('#modeli');
                let model_id_value=model_id.value
                let karoserija_id=document.querySelector('#karoserija');
                let karoserija_id_value=karoserija_id.value
                var selectedTextKaroserija = karoserija_id.options[karoserija_id.selectedIndex].text;
                let gorivo_id=document.querySelector('#gorivo');
                var selectedTextGorivo = gorivo_id.options[gorivo_id.selectedIndex].text;
                let gorivo_id_value=gorivo_id.value
                let cena_od=document.querySelector('#cena_od').value;
                let cena_do=document.querySelector('#cena_do').value;
                let sorting=document.querySelector('#sorting');
                var seletecTextSorting = sorting.options[sorting.selectedIndex].text;
                var sorting_value=sorting.value;

                if(brend_id_value!=0){
                    var selectedText = brend_id.options[brend_id.selectedIndex].text;
                    objekat.brend_id=brend_id_value;
                    string_za_ispis+="Brend: "+selectedText+"<br/>";
                }
                 if(model_id_value!=0){
                     var selectedTextModel = model_id.options[model_id.selectedIndex].text;
                    objekat.model_id=model_id_value;
                    string_za_ispis+="Model: "+selectedTextModel+"<br/>";
                }
                 if(karoserija_id_value!=0){
                    objekat.karoserija_id=karoserija_id_value;
                    string_za_ispis+="Car Body: "+selectedTextKaroserija+"<br/>";
                }
                 if(gorivo_id_value!=0){
                    objekat.gorivo_id=gorivo_id_value;
                    string_za_ispis+="Fuel: "+selectedTextGorivo+"<br/>";
                }
                 if(cena_od!=""){
                    objekat.cena_od=cena_od;
                    string_za_ispis+="Price from:"+cena_od+"<br/>";
                }
                 if(cena_do!=""){
                    objekat.cena_do=cena_do;
                    string_za_ispis+="Price to:"+cena_do+"<br/>";
                }
                 if(sorting_value!=0){
                    objekat.sorting=sorting_value;
                    string_za_ispis+="Sort: "+seletecTextSorting+"<br/>";
                }
                console.log(objekat);
                document.querySelector('#izabrano').innerHTML=string_za_ispis;
                let name_of_input=document.querySelector('#imeInput');

                document.querySelector('#save_insert').addEventListener('click',function(){
                    if(name_of_input.value.length>0){
                        let user_id=document.querySelector('#user_id').value
                        name_of_input.nextElementSibling.innerHTML="";
                        document.querySelector('#save_insert').disabled=true;
                        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                        $.ajax({
                            url: '/favourites',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            dataType: 'json', // Očekivanje JSON odgovora
                            data:{
                                "name":name_of_input.value,
                                "user_id":user_id,
                                "objekat":objekat
                            },
                            success: function (data) {
                                $("#myModal").modal("hide");
                                document.querySelector('#imeInput').value="";
                                document.querySelector('#izabrano').innerHTML="";
                                location.reload();
                            },
                            error: function (error) {
                                console.log('Error:', error.responseText);
                            },
                            complete: function () {
                                document.querySelector('#save_insert').disabled=false;
                            }
                        });
                    }
                    else{
                        name_of_input.nextElementSibling.innerHTML="This field is required";
                    }

                })

        });


}
if(document.location.pathname=="/servicepanel") {
    function filterCheckbox(selectedPaket) {
        hideAllCheckbox();
        $(`.uslugaCheckbox[data-paket="${selectedPaket}"]`).show();
    }

    function hideAllCheckbox() {
        $('.uslugaCheckbox').hide();
    }

    function showAllCheckbox() {
        $('.uslugaCheckbox').show();
    }

    var niz = [];
    window.onload = () => {
        var date=document.querySelector("#date");
        var note=document.querySelector('#note');

        let local_niz=localStorage.getItem('services')
        if(local_niz!=null){
            let splitovan_niz=local_niz.split(',');
            localStorage.removeItem('services');
            if(splitovan_niz.length>0){
                $.ajax({
                    url: '/servicepanel/choose',
                    method: 'GET',
                    data: { selectedUsluge: splitovan_niz },
                    success: function(response) {
                        // Obradi odgovor sa servera (response)
                        console.log('Filtrirane usluge:', response.filteredUsluge);
                        IspisServisa(response.filteredUsluge);
                        var chbs = document.querySelectorAll('.cekboxovi');
                        for(let element of chbs){
                            for(let element2 of response.filteredUsluge){
                                if(element.value==element2.id) element.checked=true;
                            }

                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }
        let local_date=localStorage.getItem('date');
        if(local_date!=null){
            date.value=local_date;
            localStorage.removeItem('date');
        }
        let local_note=localStorage.getItem('note');
        if(local_note!=null){
            note.value=local_note;
            localStorage.removeItem('note');
        }

        date.addEventListener('change',function (){
            let value=date.value;
            localStorage.setItem('date',value);
        })
        note.addEventListener('keyup',function (){
            if(note.value.length>=10){
                let value=note.value
                localStorage.setItem('note',value);
            }
        })
        var chbs = document.querySelectorAll('.cekboxovi');

        for (let element of chbs) {
            element.addEventListener('change', function () {
                if (element.checked) {
                    if (!niz.includes(element.value)) {
                        niz.push(element.value);
                        localStorage.setItem('services',niz);
                    }
                    $.ajax({
                        url: '/servicepanel/choose',
                        method: 'GET',
                        data: { selectedUsluge: niz },
                        success: function(response) {
                            // Obradi odgovor sa servera (response)
                            console.log('Filtrirane usluge:', response);
                            IspisServisa(response.filteredUsluge);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                } else {
                    niz = niz.filter(item => item !== element.value);
                    localStorage.setItem('services',niz);
                    if(niz.length>0){
                        $.ajax({
                            url: '/servicepanel/choose',
                            method: 'GET',
                            data: { selectedUsluge: niz },
                            success: function(response) {
                                // Obradi odgovor sa servera (response)
                                console.log('Filtrirane usluge:', response.filteredUsluge);
                                IspisServisa(response.filteredUsluge);
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    }
                    else{
                        IspisServisa(niz)
                    }

                }
            });


        }
        function  IspisServisa(niz){
            let x="";
            let ukupno=0;
            if(niz.length==0){
                document.querySelector('.usluge_lista').innerHTML="";
                document.querySelector('#ukupno').innerHTML="";
            }
            for(let element of niz){
                ukupno+=parseInt(element.price)
                x+=`<li>
                   <label class="custom-control-label" for="${element.name}">
                                <img src="${element.icon}" alt="Servis 1" class="mr-2" width="30" height="30">
                              ${element.name}
                            </label>
                     <br/>
                   </li>`
                document.querySelector('.usluge_lista').innerHTML=x;


            }
            if(ukupno!=0){
                document.querySelector('#ukupno').innerHTML='Total:'+ukupno+'$';
            }
        }
    }
}
if(document.location.pathname!='/servicepanel'){
    let servisi=localStorage.getItem('services');
    if(servisi!=null){
        localStorage.removeItem('services');
    }
}
if(document.location.pathname=="/unos"){
    document.querySelector("#brend_id").addEventListener('click',function (){
        let selected_item=document.querySelector("#brend_id").value;
        if(selected_item!=0){
            $.ajax({


                url: '/getModel/'+selected_item, // Primer URL-a
                method: 'GET', // HTTP metoda (GET, POST, itd.)
                success: function (data) {
                    IspisiModele(data);
                },
                error: function (error) {
                    console.error('AJAX error:', error);
                }
            });
            function IspisiModele(niz){
                let x="";
                for(let element of niz){
                    x+=` <option value="${element.id}">${element.naziv}</option>`
                }
                document.querySelector('#modeli').removeAttribute('disabled');
                document.querySelector('#modeli').innerHTML=x;
            }
        }
        else{
            document.querySelector('#modeli').setAttribute('disabled','true');
            document.querySelector('#modeli').innerHTML='';
        }
    })
}
if(document.location.pathname.includes('/car/')){
   let string=document.location.pathname;
   let poskidano=string.split("/");
   let splitovan_trimovan_niz=poskidano.filter(function (red){
       return red.trim();
   })
   let vehicle_id=splitovan_trimovan_niz[1];
   // window.onload=function (){
   //
   //
   // }
    $(document).ready(function (){
        let user_id=document.querySelector('#user_id');
        let objekat={};
        objekat.vehicle_id=vehicle_id;
        objekat.page=1;
        if(user_id!=null){
            objekat.user_id=user_id.value;
        }
        console.log(user_id);
        $.ajax({
            url: '/commentsAll',
            type: 'GET',
            data:objekat,
            success: function (data) {
                console.log(data);
                IspisKomentara(data.data);
                IspisPaginacije(data.last_page, data.current_page);

            },
            error: function (error) {
                console.log('Error:', error.responseTextpage);
            }
        });
    })
   var btn_dodavanje=document.querySelector('#dodavanje_komentara')
    console.log(btn_dodavanje);
    if(btn_dodavanje!=null){
    btn_dodavanje.addEventListener('click',function (e){
            e.preventDefault();
            var message_value=document.querySelector('#message').value;
            if(message_value.length>=10){
                let user_id=document.querySelector('#user_id').value;
                var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                $.ajax({
                    url: '/commentsAll',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data:{
                        vehicle_id:vehicle_id,
                        comment_text:message_value,
                        user_id:user_id,
                        page:1
                    },
                    success: function (data) {
                        console.log(data);
                        IspisKomentara(data.data);
                        IspisPaginacije(data.last_page, data.current_page);
                      document.querySelector('#message').value="";

                    },
                    error: function (error) {
                        console.log('Error:', error.responseTextpage);
                    }
                });
            }
        })
    }
    $(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();
        var page = $(this).data('id');
        let user_id=document.querySelector('#user_id').value;
        console.log(page);
        $.ajax({
            url: '/commentsAll',
            type: 'GET',
            data:{
                vehicle_id:vehicle_id,
                page:page,
                user_id:user_id
            },
            success: function (data) {
                IspisKomentara(data.data);
                IspisPaginacije(data.last_page, data.current_page);

            },
            error: function (error) {
                console.log('Error:', error.responseTextpage);
            }
        });
    });
    $(document).on('click',"#lajk_dugme",function (e){
        let user_id=document.querySelector('#user_id').value;
        e.preventDefault();
        let comment_id=$(this).data('id');
        var ikonica = $(this).find('i');
        var broj=document.querySelector("#broj_lajkova"+comment_id);
        console.log(broj);
        console.log(ikonica);
        if (ikonica.hasClass('plavo')) {
            ikonica.removeClass('plavo')
            //commentslikes
            $.ajax({
                url: '/commentslikesupdate',
                type: 'GET',
                data:{
                    user_id:user_id,
                    comment_id:comment_id,
                    page:1,
                    type:"delete"
                },
                success: function (data) {
                    console.log(data);
                    if(data==0){
                        broj.innerHTML=0;
                    }else{
                        broj.innerHTML=data;
                    }
                },
                error: function (error) {
                    console.log('Error:', error.responseTextpage);
                }
            });

        } else {
            ikonica.addClass('plavo')
            $.ajax({
                url: '/commentslikesupdate',
                type: 'GET',
                data:{
                    user_id:user_id,
                    comment_id:comment_id,
                    page:1,
                    type:"insert"
                },
                success: function (data) {
                    console.log(data);
                    broj.innerHTML=data;

                },
                error: function (error) {
                    console.log('Error:', error.responseTextpage);
                }
            });
        }
    })
   function IspisKomentara(niz){
        let  string_za_ispis=document.querySelector('#ispis_komentara');
        console.log(niz);
        let x="";
        if(niz.length==0){
            string_za_ispis.innerHTML="";
        }
        else{
            console.log(niz);
            for(let element of niz){
                x+=`
                 <div class="media">
                                <a class="pull-left" href="#"><img class="media-object" src="http://127.0.0.1:8000/assets/images/users-resize/${element.picture}" alt></a>
                                <div class="media-body">
                                    <h4 class="media-heading">${element.first_name+" "+element.last_name}</h4>
                                    <p>${element.text}</p>
                                    <ul class="list-unstyled list-inline media-detail pull-left">
                                        <li><i class="fa fa-calendar"></i>${element.date}</li>
                                        <li><a href="#" id="lajk_dugme" data-id="${element.id}">`
                                        if(element.user_has_liked==0){
                                        x+=`<i class="fa fa-thumbs-up"></i></a>`
                                        }
                                        else{
                                            x+=`<i class="fa fa-thumbs-up plavo"></i></a>`
                                        }

                                        x+=`<small  id="broj_lajkova${element.id}" style="font-size: 15px;">${element.like_count==0?0:element.like_count}</small>
                                        </li>
                                    </ul>
                                </div>
                            </div>`
            }
            string_za_ispis.innerHTML=x;
        }
   }
}
if(document.location.pathname=='/invoice'){
    window.onload = function () {
        document.querySelector('#invoice-print').addEventListener('click', function () {
            var element = document.querySelector('#printaj');
            console.log(element);

            // Provera da li je element pronađen
            if (element) {
                console.log(element);
                console.log(element);
                console.log(window);

                // Dodajte CSS pravilo za štampanje
                var style = document.createElement('style');
                style.textContent = '@media print { body { visibility: hidden; } #printaj, #printaj * { visibility: visible; } #invoice-print{display: none;}';
                document.head.appendChild(style);

                // Pokreni štampanje
                window.print();
            } else {
                console.error("Element not found. Make sure the content is loaded dynamically.");
            }
        });
    }


}
// ADMIN PANEL
if(document.location.pathname=='/brands'){
    DohvatiDelete();
}
if(document.location.pathname=='/colors'){
    DohvatiDelete();
}
if(document.location.pathname=='/car_body'){
    DohvatiDelete();
}
if(document.location.pathname=='/fuels'){
    DohvatiDelete();
}
if(document.location.pathname=='/orders_status'){
    DohvatiDelete();
}
if(document.location.pathname=='/roles'){
    DohvatiDelete();
}
if(document.location.pathname=='/service_packs'){
    DohvatiDelete();
}
if(document.location.pathname=='/vehicles/create'){

    var value=document.querySelector('#brand_id').value;
    var model_value=localStorage.getItem('model_id');
    console.log(value);
   setTimeout(function (){
       if(!document.querySelector('#djordje-none').hasAttribute('data-model')){
           document.querySelector('#djordje-none').setAttribute('data-model',value);
           document.querySelector('#djordje-none').setAttribute('data-model_id',model_value);
           $.ajax({
               url: '/getModel/' + value,
               method: 'GET',
               success: function (data) {
                   if(model_value!=0){
                       IspisiModele(data,model_value);
                   }
                   else{
                       IspisiModele(data);
                   }

               },
               error: function (error) {
                   console.error('AJAX error:', error);
               }
           });
       }
       document.querySelector('#brand_id').addEventListener('change', function () {
           let selected_item = document.querySelector("#brand_id").value;
           value=selected_item;

           if (selected_item !== "0") {
               document.querySelector('#djordje-none').setAttribute('data-model',selected_item);
               $.ajax({
                   url: '/getModel/' + value,
                   method: 'GET',
                   success: function (data) {
                       IspisiModele(data);
                   },
                   error: function (error) {
                       console.error('AJAX error:', error);
                   }
               });
           }
           else{
               document.querySelector('#djordje-none').style.display='none';
               document.querySelector('#djordje-none').removeAttribute('data-model');
           }

       });
   },500)
    document.querySelector("#model_id").addEventListener('change',function (){
         model_value=document.querySelector("#model_id").value;
        document.querySelector('#djordje-none').setAttribute('data-model_id',model_value);
        localStorage.setItem('model_id',model_value);
    })


    function IspisiModele(niz,model_id=false){
       let string_za_ispis=""
        console.log(niz);
       console.log(model_id);
       if(niz.length>0){
            let string_za_ispis=`<option value="0">Choose</option>`;
            for (let element of niz){
                string_za_ispis+=`
                <option value="${element.id}" ${element.id == parseInt(model_id) ? 'selected' : ''}>${element.name}</option>

                `
            }

           document.querySelector('#model_id').innerHTML=string_za_ispis;
           document.querySelector('#model_id').removeAttribute('disabled');
           document.querySelector('#djordje_h3').innerHTML="";
       }
       else{
           string_za_ispis=`<h3 style="color: red">This brand does not have a models</h3>`
           document.querySelector('#djordje_h3').innerHTML=string_za_ispis;
           document.querySelector('#model_id').innerHTML="";
           document.querySelector('#model_id').setAttribute('disabled',true);
       }
        document.querySelector('#djordje-none').style.display='block';
    }
}
if(document.location.pathname=='/vehicles'){
    DohvatiDelete();
}
if(document.location.pathname=='/users/create'){
    $(window).on('load',function (){
        var passwordInput = document.querySelector('#password');
        var togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    })
}
if(document.location.pathname=='/users'){
    DohvatiDelete();
}
if(document.location.pathname=='/servicing'){
    DohvatiDelete();
}
if(document.location.pathname=='/models'){
    DohvatiDelete();
}
if(document.location.pathname=='/car_price'){
    DohvatiDelete();
}
if(document.location.pathname=='/comments'){
    DohvatiDelete();
}
function DohvatiDelete(){
 $(window).on('load',function (){
     $('.brisanje').click(function (e){
         e.preventDefault();
         var id=$(this).data('id')
         var table=$(this).data('table')
         var modalData = {
             'brisanje-id': id,
             'brisanje-tabela': table
         };
         document.querySelector('#myModal').classList.add('djordje-modal');
         $('#myModal').data(modalData).addClass('djordje-modal');
         $('#otkazi').off('click');
         $('#delete').off('click');
         $('#otkazi').on('click', function () {
             $('#myModal').data('brisanje-id', null).data('brisanje-tabela', null).removeClass('djordje-modal');
         });
         $('#delete').on('click', function () {
             var brisanjeId = $('#myModal').data('brisanje-id');
             var brisanjeTabela=$('#myModal').data('brisanje-tabela');
             console.log(brisanjeId);
             console.log(brisanjeTabela)
             $.ajax({
                 url: `/${brisanjeTabela}/${brisanjeId}`,
                 type: 'DELETE',
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: niz,
                 success: function (response) {
                     if (response.success) {
                            location.reload();
                     } else {
                         toastr.error(response.error);
                     }
                 },
                 error: function (error) {
                     console.log('Error:', error.responseTextpage);
                 }
             });
         });
     })
 })
}
if(document.location.pathname=='/admin'){
    var objekat = {};

    function FilterLogs(elem) {
        objekat.page = 1;
        if (elem.hasAttribute('data-log')) {
            let log_type_value = elem.getAttribute('data-log');
            objekat.log_type = log_type_value;
        }
        if (elem.name == 'date_of') {
            let date_of_value = elem.value;
            objekat.date_of = date_of_value;
        }
        if (elem.name == 'date_to') {
            let date_to_value = elem.value;
            objekat.date_to = date_to_value;
        }
        $(document).on('click', '.pagination li a', function (e) {
            e.preventDefault();
            console.log($(this));
            var page = $(this).data('id');
            currentPage = page;
            objekat.page = page;
            $.ajax({
                url: '/admin/log',
                method: 'GET',
                data: objekat,
                success: function (data) {
                    console.log(data);
                    IspisLogova(data.data);
                    IspisPaginacije(data.last_page, data.current_page);
                },
                error: function (error) {
                    console.error('AJAX error:', error);
                }
            });
        });
        $.ajax({
            url: '/admin/log',
            method: 'GET',
            data: objekat,
            success: function (data) {
                console.log(data);
                IspisLogova(data.data);
                IspisPaginacije(data.last_page, data.current_page);
                var paginati=document.querySelector('nav ul.pagination')
                if(paginati!=null)paginati.remove();
            },
            error: function (error) {
                console.error('AJAX error:', error);
            }
        });


    }
    function IspisLogova(niz) {
        console.log(niz);
        let string_za_ispis = "";
        if (niz.length == 0) {
            string_za_ispis += `<td>No logs</td>`;
        } else {
            for (let element of niz) {
                let badgeClass = '';
                switch (element.name) {
                    case 'Login':
                        badgeClass = 'badge badge-outline-success';
                        break;
                    case 'Logout':
                        badgeClass = 'badge badge-outline-danger';
                        break;
                    case 'Register':
                        badgeClass = 'badge badge-outline-warning';
                        break;
                    default:
                        badgeClass = 'badge badge-outline-info';
                }

                string_za_ispis += `<tr>
                  <td>${element.value}</td>
                  <td>
                    <span class="${badgeClass}">${element.name}</span>
                    </td>
                </tr>`;
            }
        }
        document.querySelector('#ispis').innerHTML = string_za_ispis;
    }

}

