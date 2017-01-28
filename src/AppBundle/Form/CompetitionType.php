<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use AppBundle\Entity\ImgCompetition;
use AppBundle\Form\ImgCompetitionType;

class CompetitionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
            ->add('rubrique', TextType::class, array(
                  'attr'  => array(
                      'class' => 'form-control',
                      'autocomplete'  => 'off'
                  )
            ))
            ->add('titre', TextType::class, array(
                  'attr'  => array(
                      'class' => 'form-control',
                      'autocomplete'  => 'off'
                  )
            ))
            ->add('datedeb', TextType::class, array(
                  'attr'  => array(
                      'class' => 'form-control',
                      'autocomplete'  => 'off'
                  ),
                  'required'  => false,
            ))
            ->add('datefin', TextType::class, array(
                  'attr'  => array(
                      'class' => 'form-control',
                      'autocomplete'  => 'off'
                  ),
                  'required'  => false,
            ))
            //->add('slug')
            ->add('resume', TextareaType::class, array(
                  'attr'  => array(
                      'class' => 'form-control'
                  ),
                  'required' => 'true'
            ))
            ->add('contenu', null, array(
              'attr'  => array(
                'class' => 'ckeditor form-control'
              )
          ))
            ->add('tags', TextareaType::class, array(
                  'attr'  => array(
                      'class' => 'form-control'
                  ),
                  'required' => 'true'
            ))
            //->add('publiePar')
            //->add('modifiePar')
            //->add('publieLe')
            //->add('modifieLe')
            ->add('journee', CheckboxType::class, array(
                        'attr'  => array(
                            'class' => 'form-control',
                            'onclick'  => 'showJournee()'
                        ),
                        'required'  => false,
                  ))
            ->add('periode', CheckboxType::class, array(
                        'attr'  => array(
                            'class' => 'form-control',
                            'onclick'  => 'showPeriode()'
                        ),
                        'required'  => false,
                  ))
            ->add('statut')
            ->add('image', ImgCompetitionType::class)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Competition'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_competition';
    }


}
