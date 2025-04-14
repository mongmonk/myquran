<form class="sample-form" method="GET" action="<?php echo $_SERVER['REQUEST_URI'] ?>" target="_top">
    <select name="audio" onchange="this.form.submit()">
        <option value="ar.alafasy" <?php echo $this->input->get('audio') == 'ar.alafasy' ? 'selected' : false ?>>Alafasy</option>
        <option value="ar.abdulbasitmurattal" <?php echo $this->input->get('audio') == 'ar.abdulbasitmurattal' ? 'selected' : false ?>>Abdulbasitmurattal</option>
        <option value="ar.abdullahbasfar" <?php echo $this->input->get('audio') == 'ar.abdullahbasfar' ? 'selected' : false ?>>Abdullahbasfar</option>
        <option value="ar.abdulsamad" <?php echo $this->input->get('audio') == 'ar.abdulsamad' ? 'selected' : false ?>>Abdulsamad</option>
        <option value="ar.abdurrahmaansudais" <?php echo $this->input->get('audio') == 'ar.abdurrahmaansudais' ? 'selected' : false ?>>Abdurrahmaansudais</option>
        <option value="ar.ahmedajamy" <?php echo $this->input->get('audio') == 'ar.ahmedajamy' ? 'selected' : false ?>>Ahmedajamy</option>                        
        <option value="ar.aymanswoaid" <?php echo $this->input->get('audio') == 'ar.aymanswoaid' ? 'selected' : false ?>>Aymanswoaid</option>
        <option value="ar.hanirifai" <?php echo $this->input->get('audio') == 'ar.hanirifai' ? 'selected' : false ?>>Hanirifai</option>
        <option value="ar.hudhaify" <?php echo $this->input->get('audio') == 'ar.hudhaify' ? 'selected' : false ?>>Hudhaify</option>
        <option value="ar.husary" <?php echo $this->input->get('audio') == 'ar.husary' ? 'selected' : false ?>>Husary</option>
        <option value="ar.husarymujawwad" <?php echo $this->input->get('audio') == 'ar.husarymujawwad' ? 'selected' : false ?>>Husarymujawwad</option>
        <option value="ar.mahermuaiqly" <?php echo $this->input->get('audio') == 'ar.mahermuaiqly' ? 'selected' : false ?>>Mahermuaiqly</option>
        <option value="ar.minshawimujawwad" <?php echo $this->input->get('audio') == 'ar.minshawimujawwad' ? 'selected' : false ?>>Minshawimujawwad</option>
        <option value="ar.saoodshuraym" <?php echo $this->input->get('audio') == 'ar.saoodshuraym' ? 'selected' : false ?>>Saoodshuraym</option>
        <option value="ar.shaatree" <?php echo $this->input->get('audio') == 'ar.shaatree' ? 'selected' : false ?>>Shaatree</option>
    </select>
</form>