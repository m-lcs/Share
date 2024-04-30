<?php
namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Scategorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Doctrine\ORM\EntityRepository;

class AjoutScategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => [
                    'class' =>
                        'fw-bold'
                ]
            ])
            ->add('numero', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' =>
                    ['class' => 'fw-bold']
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
                'choice_label' => function ($categorie) {
                    return $categorie->getId() . ' - ' . $categorie->getLibelle();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.libelle', 'ASC')
                        ->addOrderBy('c.libelle', 'ASC');
                },
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn bg-primary text-white m-4'],
                'row_attr' => ['class' => 'text-center'],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Scategorie::class,
        ]);
    }
}
