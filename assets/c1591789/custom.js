/********************************************************
 *
 * @author Fred <mconyango@gmail.com>
 * Initializing and controlling redactor
 *
 *******************************************************/
var MyRedactor={
    
    options:'undefined',
            
    selector:'undefined',
            
    create:function(selector,options){
        'use strict';
        
        MyRedactor.options=options;
        
        MyRedactor.selector=selector;
        
        $(selector).redactor(options);
        
    },
    
    destroy:function(){
        'use strict';
        
        $(MyRedactor.selector).redactor('destroy');
    },
    
    recreate:function(){
        'use strict';
        
        $(MyRedactor.selector).redactor(MyRedactor.options);
    }        
 
};

