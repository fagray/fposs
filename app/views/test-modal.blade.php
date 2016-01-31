

	
	<link rel="stylesheet" type="text/css" href="/popupeasy/main.css">
	<link rel="stylesheet" type="text/css" href="/popupeasy/default.css">

	<style type="text/css">
		.overlay{
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    display: none;
}

.modal{
    display: none;
    background:#eee;
    padding:0 20px 20px;
    overflow:auto;
    z-index:1001;
    position:absolute;
    width: 500px;
    min-height: 300px;
}
	</style>
    <body>
        <a class="popeasy" href="#">Click Me
        <div class="overlay"></div>
        <div class="modal">
            <a href="#" class="closeBtn">Close Me</a>
            <!-- content here -->
        </div>

        <script src="/js/jquery-1.7.2.min.js"></script>
       <!--  // <script type="text/javascript" src="/popupeasy/highlight.pack.js"></script> -->
    <script type="text/javascript" src="/popupeasy/jquery.popeasy.js"></script>

    <script type="text/javascript">

        $(document).ready(function(){
            $('.popeasy').popeasy({
            trigger: '.popeasy',
          
            modals:'div.modal',
            animationEffect: 'slidedown',
            animationSpeed: 400,
            moveModalSpeed: 'slow',
            background: '00c2ff',
            opacity: 0.8,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
           
            close:'.closeBtn'
            });
    });
    </script>
    </body>
