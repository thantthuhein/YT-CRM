
    document.getElementById('card-content').onkeydown = function(event) {
        if ( event.which === 13 ) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
        // if ( event.which === 27 ) {
        //     $('.nameCollectEle').html("");
        //     event.preventDefault();
        //     event.stopPropagation();
        // }
    }

  var expanded = false;
  
  let phoneCollections=[];

    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
    let chooseTypes = [];

    setAirconTypes();
    setPhones();

    function setPhones(){
        if($('#phones').val() !== undefined && $('#phones').val() !== ""){
            let customerPhones =  JSON.parse($('#phones').val());

            customerPhones.forEach(function(item){
                phoneCollections.push({
                    id : item['id'],
                    phone: item.hasOwnProperty("phone_number") ? item['phone_number'] : item['phone'],
                });
            })

            $("#phones").val(JSON.stringify(phoneCollections));
        }
    }

    function setAirconTypes(){
        if($('#tempAirconTypes').val() !== undefined){
            
            let tempAirconTypes = JSON.parse($("#tempAirconTypes").val());
        
            tempAirconTypes.forEach(function(type){
                chooseTypes.push({
                        id : type.id,
                        type : type.type
                    });
            })
        }        
    }
    document.querySelectorAll('input[type=checkbox]').forEach(function(element){
        let selectCollections = "";
        element.addEventListener('click', function(event){
            let checkEle = event.target.dataset.name;
            let checkEleId = event.target.dataset.id;
            let child = JSON.parse(event.target.dataset.child);
            let parent = JSON.parse(event.target.dataset.parent);

            let existedEle = false;        

            for(let type of chooseTypes){
                if(type.id == checkEleId){
                    existedEle = true; // true mean to uncheck element
                    break;
                }
            }
            if(existedEle){
                chooseTypes = chooseTypes.filter(function(item){
                    return item.id != checkEleId;
                })
            }
            else{
                chooseTypes.push({
                    id : checkEleId,
                    type : checkEle
                });
            }
            
            let templateList = "";
            
            if(existedEle){
                //unselect and remove child from list
                chooseTypes = checkSelectChild(child, chooseTypes);
            }
            else{
                //select and add parent to list
                chooseTypes = checkSelectParent(parent, chooseTypes);
            }
                                    
            chooseTypes.forEach(function(type){
                templateList += `<li class="selection-multiple-item" value="${type.type}"><span style="white-space: nowrap;">${type.type}</span></li>`;
                // templateList += `<li class="selection-multiple-item" value="${type.type}">${type.type}<span class="remove" data-id="${type.id}">x</span></li>`;
            })

            

            $('.aircontype_select').html(templateList);
            
        });
    })

    function checkSelectParent(parent, chooseTypes){
        if(parent != 0){
            let parentEle = document.getElementById(`aircontype-${parent}`);
            
            parentEle.checked = true;

            
            let existedEle = false;
            for(let type of chooseTypes){
                if(type.id == parent){
                    existedEle = true; 
                    break;
                }
            }
            if(!existedEle){
                chooseTypes.push({
                    id : parent,
                    type : parentEle.dataset.name
                });
            }

            let nextParent = parentEle.dataset.parent;
            return checkSelectParent(nextParent, chooseTypes);
        }
        else{
            return chooseTypes;
        } 
    }
    function checkSelectChild(child, chooseTypes){
        
        if(child.length > 0){
            for(let chi of child){
                let childEle = document.getElementById(`aircontype-${chi}`);
                

                chooseTypes = chooseTypes.filter(function(item){
                    return item.id != chi;
                })
               
                childEle.checked = false;

                chooseTypes = checkSelectChild(JSON.parse(childEle.dataset.child), chooseTypes);
            }
            return chooseTypes;
        }
        else{
            return chooseTypes;
        }
    }
    this.input = document.querySelector("#customer_name");
    const debounce = {
        debounce (func, wait, immediate) {
            
            let timeout;
            return function() {
                let context = this, args = arguments;
                let later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                let callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }
    }

    this.input.addEventListener('keyup',debounce.debounce((event) => search(event),200));
    this.input.addEventListener('focus', debounce.debounce((event) => search(event),200));
    // this.input.addEventListener('blur', function(){
    //     $('.nameCollectEle').html("");
    // });

    function search(event){
        $('.nameCollectEle').show();

        name=event.target.value;
            fetch(`/api/v1/searchCustomer?name=${name}`,{
                method: "Get",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
            })
            .then(res => (res.json()))
            .then(data=>{
                data = data.data;
                
                let nameEle = document.querySelector('.nameCollectEle');
                nameEle.innerHTML = "";
                if (data != null && data != "" && data.length > 0) {
                    let nameCollections = "";
                        data.forEach(function(item){
                            // nameCollections += `<div class="parent px-2 py-1" style="cursor:pointer;">
                            //                         <p data-id=${item.id} onClick='ClickName(${item.id})'>
                            //                             ${item.name}
                            //                         </p>
                            //                     </div>`;

                            nameCollections += `<div class="mr-2 p-1" style="border: 1px solid #ced4da; border-radius: 5px;"
                                                    data-id=${item.id} onClick='ClickName(${item.id})'>
                                                    ${item.name}
                                                </div>`;
                        })

                        let nameEle = document.querySelector('.nameCollectEle');

                        nameEle.innerHTML = nameCollections;
                    
                }
                else{
                    $('.remove-old-customer').hide();
                    // $('#customer_email').val("");
                    $("#isOld").value="false";
                    $("#customer_id").value= null;
                }
            })
    }

    function ClickName(id){
        $('.remove-old-customer').show();

        // $('.nameCollectEle').hide();

        fetch(`/api/v1/customers/${id}`,{
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
        }) 
        .then(res => (res.json()))
        .then(customer => {
            customer = customer.data;
            $('#customer_name').val(customer.name);

            let phones = [];
            for(let phone of customer.phone_number)
            {
                phones.push(phone.phone_number);
            }

            $('#email-phone-wrapper').hide();
            $('#cust-info-tbl').show();
            $('#isOld').val(true);
            $('#customer_id').val(customer.id);

            $('#cust-info-tbl table').html(`<tbody>
                                            <tr style="border-bottom: 1px solid #dee2e6">
                                                <th>Email</th>
                                                <td>${customer.email == null ? "-" : customer.email}</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #dee2e6">
                                                <th>Phone</th>
                                                <td>${phones.join(', ')}</td>
                                            </tr>
                                        </tbody>`);
        })        
    }

    this.removeOldCustomer = document.querySelector('.remove-old-customer');

    if(this.removeOldCustomer !== null){
        this.removeOldCustomer.addEventListener('click', function(){
            $(this).hide();
            $('.nameCollectEle').html("");
            $('#email-phone-wrapper').show();
            $('#cust-info-tbl').hide();
            $('#isOld').val(false);
            $('#customer_id').val(null);

            $('#customer_name').val("");
            $('#customer_email').val("");
            $('#customer_phone').val("");
            $('#phones').val("");
        })
    }

    let company=document.getElementById('company');
    company.addEventListener('keyup',debounce.debounce((event) => searchCompany(event),500));
    company.addEventListener('focus',debounce.debounce((event) => searchCompany(event),500));
        
    function searchCompany(event){
        company_name=event.target.value;
        
        fetch(`/api/v1/searchCompany?name=${company_name}`,{
            method: "Get",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
        })
        .then(res => (res.json()))
        .then(data=>{
            
            if (data != null) {
                let nameCollections = "";
                    data.forEach(function(item){
                        // nameCollections += `<div class="parent px-2 py-1"><p data-id=${item.id} onclick="ClickCompany(${item.id},'${item.name}')">${item.name}</div>`;
                        nameCollections += `<div class="mr-2 p-1" style="border: 1px solid #ced4da; border-radius: 5px;"
                                                data-id=${item.id} onClick='ClickCompany(${item.id}, "${item.name}")'>
                                                ${item.name}
                                            </div>`;
                    })

                    let nameEle = document.querySelector('.nameCompanyEle');

                    nameEle.innerHTML = nameCollections;
                
            }
        })
    }

    function ClickCompany(id,name){
        document.getElementById('company').value=name;
        document.getElementById('isOldCompany').value="true";
        document.getElementById('company_id').value=id;
        // document.getElementById('company').name=$id;
        $('.remove-old-company').show();
        // $( ".nameCompanyEle" ).hide(); 
    }

    this.removeOldCompany = document.querySelector('.remove-old-company');

    if(this.removeOldCompany !== null){
        this.removeOldCompany.addEventListener('click', function(){
            $(this).hide();
            $('#company').val("");
            $('#isOldCompany').val(false);
            $('#company_id').val(null);
            $( ".nameCompanyEle" ).html(""); 

        })
    }
    
    function addInputFieldValue(){
        let uniqueId = Date.now();
        let phone_no=document.getElementById('customer_phone').value;
        
        if(phone_no == ""){
            return;
        }
        phoneCollections.push({
            id : uniqueId,
            phone: phone_no
        });
        
        appendPhoneNumberToHtml();

        document.getElementById('customer_phone').value='';
    }

    function removePhone(index){
        if(phoneCollections.length == 1)
        {
            alert("At least one phone number must left!");
            return;
        }
        else{
            phoneCollections = phoneCollections.filter(function(item){
                return item.id != index;
            })
        }

        appendPhoneNumberToHtml()
    }

    function removeOldPhone(index) {
        // 
        // 
        let phones = document.getElementById('phones')
        
        phoneCollections = JSON.parse(phones.value).filter(function(item){
            return item.id == index;
        })

        appendPhoneNumberToHtml()
    }

    function appendPhoneNumberToHtml(){
        let htmlString = "";
        $(".phone_number_show").html("");
        phoneCollections.forEach(function(item){
            htmlString += `<li data-id="${item.id}" class="selection-multiple-item">${item.phone}<span class="remove" data-id="${item.id}" style="cursor:pointer" onclick="removePhone(${item.id})">x</span></li>`; 
        })
        $(".phone_number_show").append(htmlString);

        $("#phones").val(JSON.stringify(phoneCollections));
    }
    function changeEnquiry(){
        let enquiryId = document.getElementById("enquiries_type_id").value;
        
        if ( enquiryId == 2 ){
            $(".future-input option[value='No']").removeAttr('selected');
            $(".future-input option[value='Yes']").attr('selected','selected');
            $(".status-input option[value='inactive']").removeAttr('selected');
            $(".status-input option[value='active']").attr('selected','selected');
               
        }
        else{
            $(".future-input option[value='Yes']").removeAttr('selected');
            $(".future-input option[value='No']").attr('selected','selected');
            $(".status-input option[value='pending']").removeAttr('selected');
            $(".status-input option[value='inactive']").attr('selected','selected');

        }

    }
    
    function changeFutureAction() {
        let element = document.getElementById("has_future_action").value;
        if ( element == 'Yes') {
            $(".status-input option[value='inactive']").removeAttr('selected');
            $(".status-input option[value='active']").attr('selected','selected');
        } else {
            $(".status-input option[value='active']").removeAttr('selected');
            $(".status-input option[value='inactive']").attr('selected','selected');
        }
    }
    
    function checkCompanyAndProject() {
        let company = document.getElementById('company').value;
        let project = document.getElementById('project_name').value;
        
        let id = $('#enquiry-update').data('id');

        fetch(`/api/v1/checkCompanyAndProject?company_name=${company}&project_name=${project}&id=${id}`,{
            method: "Get",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            
            if(data.match){
                $('.company-project-error').html(`<small class='text-danger small-message'>Company And Project already existed</small>`)
            }
            else{
                $('.company-project-error').html("");
            }
        })
        .catch(error => {
            
        })

    }