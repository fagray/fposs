<script src="https://code.responsivevoice.org/responsivevoice.js"></script>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>

<textarea id="text" cols="45" rows="3">Hello world</textarea>
 
<select id="voiceselection"></select> 
 
<input 
  onclick="responsiveVoice.speak($('#text').val(),$('#voiceselection').val());" 
  type="button" 
  value="Play" 
/>
 
<script>
	responsiveVoice.speak('hi raymund');
        //Populate voice selection dropdown
        var voicelist = responsiveVoice.getVoices();
 
        var vselect = $("#voiceselection");
 
        $.each(voicelist, function() {
                vselect.append($("<option />").val(this.name).text(this.name));
        });
</script>