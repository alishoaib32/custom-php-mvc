document.onreadystatechange = function(e)
{
    console.log('loading...');
    if(localStorage.getItem('is_login')!=='yes'){
        window.location='/login';
    }else{
        $("#acl_blade").show();
    }
};


