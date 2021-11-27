function my_timer(el, t, t2)
{
        if(arguments.length < 2)
        {
                alert('Вы указали всего один парамет!');
                return false;
        }
       
        var test = document.getElementById(el), setTimer, d, t2;
       
        if(arguments.length == 2)
        {
                d = new Date();
                t3 = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
                t2 = t;
                t = t3;
        }
 
        setTimer = setInterval(function(){
               
                d = new Date();
               
                t3 = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
               
                if(t <= t3)
                {
                        el.innerHTML = t3;
                       
                        if(t2 == t3)
                        {
                              alert('Время истекло!');
                              clearInterval(setTimer); 
                        }
                }
               
        }, 16);
}
 
window.onload = function()
{
my_timer('test', '17:3:30');
}