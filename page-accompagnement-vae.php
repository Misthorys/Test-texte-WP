<?php get_header(); ?>

<!-- Page Header avec bouton retour -->
<section class="page-header">
  <div class="section-container">
    <!-- Bouton retour -->
    <div class="back-to-home">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="back-btn">
        <span class="back-arrow">←</span>
        <span>Retour à l'accueil</span>
      </a>
    </div>
    
    <h1><?php echo esc_html(isabel_get_option('isabel_vae_title', 'Accompagnement VAE')); ?></h1>
    <p class="subtitle"><?php echo esc_html(isabel_get_option('isabel_vae_subtitle', 'Valorisez votre expérience et obtenez une reconnaissance officielle de vos compétences')); ?></p>
  </div>
</section>

<!-- Page Content -->
<div class="page-content">
  <!-- Section Certification Qualiopi - MODIFIABLE DEPUIS LE CUSTOMIZER -->
  <?php isabel_display_qualiopi_section('page'); ?>

  <div class="content-section">
    <h2><?php echo esc_html(isabel_get_option('isabel_vae_section1_title', 'Qu\'est-ce que la VAE ?')); ?></h2>
    <p><?php echo esc_html(isabel_get_option('isabel_vae_intro', 'La Validation des Acquis de l\'Expérience (VAE) est un dispositif qui permet de faire reconnaître officiellement vos compétences acquises par l\'expérience professionnelle.')); ?></p>
    
    <p><?php echo esc_html(isabel_get_option('isabel_vae_description', 'Avec au moins 3 ans d\'expérience dans le domaine visé, vous pouvez prétendre à une VAE. C\'est une opportunité unique de valoriser votre parcours.')); ?></p>
  </div>

  <!-- Nouvelle grille avec 2 boxes texte + 2 boxes images - TAILLES CORRIGÉES -->
  <div class="benefits-grid-fixed">
    <!-- Box 1 - Texte uniquement -->
    <div class="benefit-card-fixed text-card-fixed">
      <h3>
        <span class="benefit-icon"><?php echo esc_html(isabel_get_option('isabel_vae_box1_icon', '🎓')); ?></span> 
        <?php echo esc_html(isabel_get_option('isabel_vae_box1_title', 'Reconnaissance officielle')); ?>
      </h3>
      <p><?php echo esc_html(isabel_get_option('isabel_vae_box1_text', 'Obtenez un diplôme ou une certification reconnue par l\'État, équivalente à une formation traditionnelle.')); ?></p>
    </div>
    
    <!-- Box 2 - Image pure (remplit toute la box) -->
    <div class="benefit-card-fixed image-only-card-fixed">
      <?php 
      $box2_image = isabel_get_option('isabel_vae_box2_image', '');
      if (!empty($box2_image)) {
        echo '<div class="image-wrapper">';
        echo '<img src="' . esc_url($box2_image) . '" alt="Image VAE" class="full-box-image-fixed" />';
        echo '</div>';
      } else {
        echo '<div class="full-box-placeholder-fixed">';
        echo '<div class="placeholder-content">';
        echo '<span class="placeholder-text">IMAGE</span>';
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
    
    <!-- Box 3 - Texte uniquement -->
    <div class="benefit-card-fixed text-card-fixed">
      <h3>
        <span class="benefit-icon"><?php echo esc_html(isabel_get_option('isabel_vae_box3_icon', '💼')); ?></span> 
        <?php echo esc_html(isabel_get_option('isabel_vae_box3_title', 'Evolution professionnelle')); ?>
      </h3>
      <p><?php echo esc_html(isabel_get_option('isabel_vae_box3_text', 'Accédez à de nouvelles opportunités de carrière et augmentez votre employabilité.')); ?></p>
    </div>
    
    <!-- Box 4 - Image pure (remplit toute la box) -->
    <div class="benefit-card-fixed image-only-card-fixed">
      <?php 
      $box4_image = isabel_get_option('isabel_vae_box4_image', '');
      if (!empty($box4_image)) {
        echo '<div class="image-wrapper">';
        echo '<img src="' . esc_url($box4_image) . '" alt="Image VAE" class="full-box-image-fixed" />';
        echo '</div>';
      } else {
        echo '<div class="full-box-placeholder-fixed">';
        echo '<div class="placeholder-content">';
        echo '<span class="placeholder-text">IMAGE</span>';
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
  </div>

  <!-- Process Steps -->
  <div class="process-steps">
    <h3><?php echo esc_html(isabel_get_option('isabel_vae_process_title', 'Les étapes de votre VAE')); ?></h3>
    <div class="steps-list">
      <div class="step-item">
        <div class="step-number">1</div>
        <div class="step-content">
          <h4>Étude de faisabilité</h4>
          <p><?php echo esc_html(isabel_get_option('isabel_vae_step1', 'Analyse de votre parcours et identification du diplôme le plus adapté à votre expérience professionnelle.')); ?></p>
        </div>
      </div>
      
      <div class="step-item">
        <div class="step-number">2</div>
        <div class="step-content">
          <h4>Constitution du dossier</h4>
          <p><?php echo esc_html(isabel_get_option('isabel_vae_step2', 'Aide à la rédaction du livret 1 (recevabilité) et accompagnement dans les démarches administratives.')); ?></p>
        </div>
      </div>
      
      <div class="step-item">
        <div class="step-number">3</div>
        <div class="step-content">
          <h4>Rédaction du livret 2</h4>
          <p><?php echo esc_html(isabel_get_option('isabel_vae_step3', 'Accompagnement personnalisé pour la rédaction du dossier de validation détaillant vos compétences.')); ?></p>
        </div>
      </div>
      
      <div class="step-item">
        <div class="step-number">4</div>
        <div class="step-content">
          <h4>Préparation au jury</h4>
          <p><?php echo esc_html(isabel_get_option('isabel_vae_step4', 'Simulation d\'entretien et conseils pour présenter votre dossier avec confiance devant le jury.')); ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Detailed Content -->
  <div class="content-section">
    <h2><?php echo esc_html(isabel_get_option('isabel_vae_section2_title', 'Qui peut bénéficier de la VAE ?')); ?></h2>
    <p><?php echo esc_html(isabel_get_option('isabel_vae_who', 'Toute personne justifiant d\'au moins 3 ans d\'expérience professionnelle, bénévole ou de formation en rapport avec le diplôme visé.')); ?></p>
  </div>

  <div class="content-section">
    <h2><?php echo esc_html(isabel_get_option('isabel_vae_section3_title', 'Mon expertise VAE')); ?></h2>
    <p><?php echo esc_html(isabel_get_option('isabel_vae_expertise', 'Forte de mon expérience en accompagnement VAE, je vous guide dans toutes les étapes de votre démarche.')); ?></p>
  </div>

  <div class="content-section">
    <h2><?php echo esc_html(isabel_get_option('isabel_vae_section4_title', 'Diplômes et certifications concernés')); ?></h2>
    <p><?php echo esc_html(isabel_get_option('isabel_vae_diplomas', 'La VAE permet d\'obtenir des diplômes de tous niveaux : CAP, Bac professionnel, BTS, DUT, Licence, Master, titres professionnels, certificats de qualification professionnelle (CQP).')); ?></p>
  </div>

  <!-- CTA Section -->
  <div class="cta-service">
    <h3><?php echo esc_html(isabel_get_option('isabel_vae_cta_title', 'Prêt(e) à valoriser votre expérience ?')); ?></h3>
    <p><?php echo esc_html(isabel_get_option('isabel_vae_cta_text', 'Contactez-moi pour une première évaluation de votre projet VAE et découvrons ensemble les possibilités qui s\'offrent à vous.')); ?></p>
    <button class="btn-cta" onclick="openPopup()"><?php echo esc_html(isabel_get_option('isabel_vae_cta_button', 'Évaluer mon projet VAE')); ?></button>
  </div>
</div>

<!-- CSS CORRIGÉ pour les nouvelles boxes + bouton retour + Qualiopi -->
<style>
/* Bouton retour */
.back-to-home {
  margin-bottom: 2rem;
}

.back-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
  padding: 0.5rem 1rem;
  border-radius: 25px;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
}

.back-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  transform: translateX(-3px);
}

.back-arrow {
  font-size: 1.1rem;
  transition: transform 0.3s ease;
}

.back-btn:hover .back-arrow {
  transform: translateX(-2px);
}

/* Certification Qualiopi */
.qualiopi-certification {
  background: linear-gradient(135deg, #f8fafc, #e2e8f0);
  border: 2px solid #cbd5e1;
  border-radius: 16px;
  padding: 2rem;
  margin: 2rem 0 3rem 0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.qualiopi-content {
  display: flex;
  align-items: center;
  gap: 2rem;
  max-width: 600px;
  margin: 0 auto;
}

.qualiopi-logo {
  flex-shrink: 0;
}

.qualiopi-logo img {
  height: 80px;
  width: auto;
  object-fit: contain;
}

.qualiopi-text h3 {
  color: #1e40af;
  font-size: 1.3rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  margin-top: 0;
}

.qualiopi-text p {
  color: #475569;
  font-size: 0.95rem;
  line-height: 1.5;
  margin: 0;
  font-style: italic;
}

/* Grille avec tailles réduites */
.benefits-grid-fixed {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  margin: 2rem 0;
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}

/* Box générale - TAILLE RÉDUITE */
.benefit-card-fixed {
  border-radius: 12px;
  border: 2px solid var(--rose-300);
  transition: all 0.3s ease;
  height: 180px; /* HAUTEUR FIXE RÉDUITE */
  overflow: hidden;
}

.benefit-card-fixed:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(196, 125, 217, 0.3);
}

/* Box texte */
.text-card-fixed {
  background: linear-gradient(135deg, var(--white), var(--rose-300));
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: center;
}

.text-card-fixed h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.text-card-fixed .benefit-icon {
  font-size: 1.3rem;
}

.text-card-fixed p {
  color: var(--text-light);
  line-height: 1.5;
  font-size: 0.9rem;
  margin: 0;
}

/* Box image pure - CORRIGÉE */
.image-only-card-fixed {
  padding: 0 !important;
  position: relative;
  background: var(--rose-300);
  opacity: 0.8;
}

.image-wrapper {
  width: 100%;
  height: 100%;
  position: relative;
  overflow: hidden;
}

.full-box-image-fixed {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.3s ease;
  display: block;
}

.full-box-image-fixed:hover {
  transform: scale(1.05);
}

/* Placeholder pour les images manquantes */
.full-box-placeholder-fixed {
  width: 100%;
  height: 100%;
  background: var(--rose-300);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.placeholder-content {
  text-align: center;
}

.placeholder-text {
  color: var(--rose-700);
  font-size: 16px;
  font-weight: bold;
  letter-spacing: 1px;
}

/* Responsive */
@media (max-width: 768px) {
  .qualiopi-content {
    flex-direction: column;
    text-align: center;
    gap: 1.5rem;
  }
  
  .qualiopi-logo img {
    height: 60px;
  }
  
  .qualiopi-text h3 {
    font-size: 1.1rem;
  }
  
  .benefits-grid-fixed {
    grid-template-columns: 1fr;
    gap: 1rem;
    max-width: 100%;
  }
  
  .benefit-card-fixed {
    height: 150px; /* Plus petit sur mobile */
  }
  
  .text-card-fixed {
    padding: 1.25rem;
  }
  
  .text-card-fixed h3 {
    font-size: 1rem;
  }
  
  .text-card-fixed p {
    font-size: 0.85rem;
  }
  
  .back-btn {
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
  }
}

@media (max-width: 480px) {
  .benefit-card-fixed {
    height: 140px; /* Encore plus petit sur très petit écran */
  }
  
  .text-card-fixed {
    padding: 1rem;
  }
  
  .qualiopi-certification {
    padding: 1.5rem;
  }
}
</style>

<?php get_footer(); ?>