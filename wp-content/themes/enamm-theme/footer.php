<!-- <footer>
  <div class="footerContainer">
    <div class="footerTop">
      <img src="" class="footerTop__image" alt="">
      <div class="footerTop__legales footerTop__cts">
        <h3 class="footerTop__ct--title">ASPECTOS LEGALES</h3>
        <div class="footerTop__ct--items">
          <a href="#">Libro de reclamaciones</a>
          <a href="#">Política de datos personales</a>
          <a href="#">Anticorrupción</a>
        </div>
      </div>
      <div class="footerTop__servicios footerTop__cts">
        <h3 class="footerTop__ct--title">NUESTROS SERVICIOS</h3>
        <div class="footerTop__ct--items">
          <a href="#">Aula virtual</a>
          <a href="#">Repositorio Digital</a>
          <a href="#">Biblioteca virtual</a>
          <a href="#">Intranet</a>
          <a href="#">Calidad educativa</a>
          <a href="#">Sistema integrado</a>
          <a href="#">Webmail</a>
          <a href="#">Bolsa de trabajo</a>
          <a href="#">Convocatoria a elecciones CPC</a>
          <a href="#">Trabaja con nosotros</a>
        </div>
      </div>
      <div class="footerTop__interes footerTop__cts">
        <h3 class="footerTop__ct--title">ENLACES DE INTERÉS</h3>
        <div class="footerTop__ct--items">
          <a href="#">COVID-19</a>
          <a href="#">Estadísticas COVID-19</a>
          <a href="#">Evaluación Síntomas COVID-19</a>
          <a href="#">Denuncias Laborables</a>
          <a href="#">Mesa de Partes</a>
          <a href="#">Acceso a la Información Pública</a>
          <a href="#">Denuncia un Acto de Corrupción</a>
          <a href="#">Plan Estratégico Institucional</a>
          <a href="#">Información institucional</a>
        </div>
      </div>
      <div class="footerTop__centro footerTop__cts">
        <h3 class="footerTop__ct--title">CENTRO PRE ENAMM</h3>
        <div class="footerTop__ct--items">
          <a href="#">Pre Marina Mercante</a>
          <a href="#">Pre Administración Marítima Portuaria</a>
        </div>
      </div>
    </div>
    <div class="footerMiddle"></div>
    <div class="footerBottom">
      <div class="footerTop__contactos footerTop__cts">
        <h3 class="footerTop__ct--title">CONTÁCTANOS</h3>
        <div class="footerTop__ct--itemsCt">
          <div class="footerTop__ct--items footerTop__ct--itemsTop">
            <a>Av. Progreso 632 Chucuito, Callao</a>
            <a>+51 966 539 260</a>
            <a>informes@enamm.edu.pe</a>
          </div>
          <div class="footerTop__ct--items footerTop__ct--itemsBottom">
            <a>Horario de Atención:</a>
            <a>LUN a VIE: 09:00 am – 04:00 pm</a>
          </div>
        </div>
      </div>
      <div class="footerTop__admision footerTop__cts">
        <h3 class="footerTop__ct--title">ADMISIÓN ENAMM</h3>
        <div class="footerTop__ct--items">
          <a>+51 951 895 870</a>
          <a>admision@enamm.edu.pe</a>
        </div>
      </div>
    </div>
  </div>
</footer> -->

<footer>
  <div class="footerContainer">
    <div class="footerTop">
      <?php
      $footer_options = get_option( 'enamm_footer_options' );

      // Logo del Footer (sin cambios, ya que es un campo simple)
      if ( ! empty( $footer_options['footer_logo'] ) ) {
          echo '<img src="' . esc_url( $footer_options['footer_logo'] ) . '" class="footerTop__image" alt="' . esc_attr( get_bloginfo( 'name' ) . ' logo' ) . '">';
      }
      ?>

      <?php
      function enamm_render_footer_links_section( $title_key, $links_key, $options_array ) {
          $title = esc_html( $options_array[$title_key] ?? '' );
          $links_json = $options_array[$links_key] ?? '[]';
          $links = json_decode( $links_json, true ); // Decodificar el JSON

          if ( ! empty( $title ) && is_array( $links ) && count( $links ) > 0 ) : ?>
            <div class="footerTop__cts"> <h3 class="footerTop__ct--title"><?php echo $title; ?></h3>
              <div class="footerTop__ct--items">
                <?php foreach ( $links as $link ) : ?>
                  <?php if ( ! empty( $link['url'] ) && ! empty( $link['text'] ) ) : ?>
                    <a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['text'] ); ?></a>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif;
      }
      ?>

      <?php enamm_render_footer_links_section( 'footer_legal_title', 'footer_legal_links', $footer_options ); ?>

      <?php enamm_render_footer_links_section( 'footer_services_title', 'footer_services_links', $footer_options ); ?>

      <?php enamm_render_footer_links_section( 'footer_interest_title', 'footer_interest_links', $footer_options ); ?>

      <?php enamm_render_footer_links_section( 'footer_centro_pre_title', 'footer_centro_pre_links', $footer_options ); ?>


    </div>
    <div class="footerMiddle"></div>
    <div class="footerBottom">
      <div class="footerTop__contactos footerTop__cts">
        <h3 class="footerTop__ct--title"><?php echo esc_html( $footer_options['footer_contact_title'] ?? 'CONTÁCTANOS' ); ?></h3>
        <div class="footerTop__ct--itemsCt">
          <div class="footerTop__ct--items footerTop__ct--itemsTop">
            <a><?php echo esc_html( $footer_options['footer_contact_address'] ?? '' ); ?></a>
            <a><?php echo esc_html( $footer_options['footer_contact_phone'] ?? '' ); ?></a>
            <a><?php echo esc_html( $footer_options['footer_contact_email'] ?? '' ); ?></a>
          </div>
          <div class="footerTop__ct--items footerTop__ct--itemsBottom">
            <a><?php echo esc_html( $footer_options['footer_contact_hours_title'] ?? '' ); ?></a>
            <a><?php echo esc_html( $footer_options['footer_contact_hours_time'] ?? '' ); ?></a>
          </div>
        </div>
      </div>

      <div class="footerTop__admision footerTop__cts">
        <h3 class="footerTop__ct--title"><?php echo esc_html( $footer_options['footer_admission_title'] ?? 'ADMISIÓN ENAMM' ); ?></h3>
        <div class="footerTop__ct--items">
          <a><?php echo esc_html( $footer_options['footer_admission_phone'] ?? '' ); ?></a>
          <a><?php echo esc_html( $footer_options['footer_admission_email'] ?? '' ); ?></a>
        </div>
      </div>
    </div>
  </div>
</footer>