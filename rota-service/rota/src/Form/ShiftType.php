<?php

namespace App\Form;

use App\Entity\Rota;
use App\Entity\Shift;
use App\Entity\Staff;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime')
            ->add('endTime')
            ->add('rota', EntityType::class, ['class' => Rota::class, 'choice_label' => function(Rota $rota) {return $rota->getWeekCommenceDate()->format('d-m-Y');}])
            ->add('staff', EntityType::class, ['class' => Staff::class, 'choice_label' => function(Staff $staff) {return "{$staff->getFirstName()} {$staff->getSurname()}";}])
            ->add('send', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shift::class,
        ]);
    }
}
