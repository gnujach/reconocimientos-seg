<?php $centros = array(
    "Delegación Regional",
    "Usae San José Iturbide",
    "Usae San Luis de la Paz",
    "Usae Santa Catarina",
    "Usae Victoria",
    "Usae Dr. Mora",
    "Usae Atargea",
    "Usae Xichu",
    "Usae Tierra Blanca",
);?>
<h3>Fecha de Nacimiento</h2>
    <table class="form-table">
        <tr>
            <th><label for="user_birthday">Cumpleaños</label></th>
            <td>
                <input
                    type="date"
                    value="<?php echo esc_attr(get_user_meta($user->ID, 'f_nacimiento', true)); ?>"
                    name="f_nacimiento"
                    id="user_birthday"
                    required
                >
                <p class="description">Fecha de Nacimiento</p>
            </td>
        </tr>
    </table>
<h3><?php _e('Información Laboral', 'textdomain'); ?></h3>
    
    <table class="form-table">
        <tr>
            <th>
                <label for="c_adscripcion"><?php _e('Centro de Adscripción', 'textdomain'); ?></label>
            </th>
            <td>
                <?php $selected = esc_attr( get_the_author_meta( 'c_adscripcion', $user->ID ) );?>                
                <select name="c_adscripcion" id="c_adscripcion">
                    <?php                                                
                        foreach ( $centros as $centro ) {
                            if ( $selected == $centro )
                                echo '<option value ="'.$centro.'" selected>'.$centro.'</option>';
                            else
                                echo '<option value ="'.$centro.'">'.$centro.'</option>';
                        }
                    ?>
                </select>
              <!--  <input type="text" name="c_adscripcion" id="c_adscripcion" value="<?php echo esc_attr( get_the_author_meta( 'c_adscripcion', $user->ID ) ); ?>" class="regular-text" required />
                <p class="description"><?php _e('Centro de Adscripción.', 'textdomain'); ?></p>-->
            </td>
        </tr>
        <tr>
            <th>
                <label for="puesto"><?php _e('Puesto', 'textdomain'); ?></label>
            </th>
            <td>
                <input type="text" name="puesto" id="puesto" value="<?php echo esc_attr( get_the_author_meta( 'puesto', $user->ID ) ); ?>" class="regular-text" required/>
                <p class="description"><?php _e('Puesto', 'textdomain'); ?></p>
            </td>
        </tr>
    </table>