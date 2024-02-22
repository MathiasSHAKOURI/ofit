<?php

namespace App\DataFixtures\Provider;

class OfitProvider
{
    private $exercices = [
        'Abdominaux' => [
            'Crunchs',
            'Planche',
            'Relevé de jambes suspendu',
            'Sit-ups',
            'Roue abdominale',
        ],
        'Adducteurs' => [
            'Machine à adducteurs',
            'Écartements latéraux des jambes',
            'Squats sumo',
            'Fentes latérales',
        ],
        'Biceps' => [
            'Curl avec barre EZ',
            'Curl avec haltères',
            'Curl marteau',
            'Curl incliné',

        ],
        'Mollets' => [
            'Élévation des mollets debout',
            'Élévation des mollets assis',
            'Élévation des mollets à la machine',
            'Skipping',
        ],
        'Pectoraux' => [
            'Développé couché',
            'Pompes',
            'Écarté incliné avec haltères',
            'Pull-over avec haltère',
        ],
        'Avant-bras' => [
            'Curl inversé avec barre',
            'Lever de poignet avec haltères',
            'Flexion des poignets avec une barre',
        ],
        'Fessiers' => [
            'Hip thrusts',
            'Fentes arrière',
        ],
        'Ischio-jambiers' => [
            'Soulevé de terre jambes tendues',
            'Flexion des jambes à la machine',
            'Fentes avec barre',
        ],
        'Dos' => [
            'Soulevé de terre',
            'Tirage à la barre fixe',
            'Rowing à la machine',
            'Pull-down à la machine',
            'Tractions',
        ],
        'Quadriceps' => [
            'Squats',
            'Leg press',
            'Fentes avant',
            'Extensions des jambes à la machine',
        ],
        'Trapèzes' => [
            'Shrugs avec haltères',
            'Shrugs à la barre',
            'Rowing à la barre en T',
        ],
        'Triceps' => [
            'Dips',
            'Extensions des triceps à la poulie haute',
            'Pushdowns à la poulie',
            'Barre au front',
        ],
        'Epaules' => [
            'Développé militaire avec barre',
            'Développé militaire avec haltères',
            'Élévation latérale avec haltères',
            'Élévation frontale avec haltères',
            'Rowing menton avec barre',
            'Shrugs pour les épaules',
        ],
        'Lombaires' => [
            'Extensions lombaires sur machine',
            'Supermans',
            'Hyperextensions au banc',
            'Extensions lombaires au sol',
            'Good mornings',
            'Élévations de bassin',
            'Extensions lombaires sur Swiss ball',
        ]
    ];

    private $workoutPrograms = [
        'Programme Force et Puissance',
        'Entraînement Hypertrophie Max',
        'Plan Musculaire Total',
        'Projet Corps Sculpté',
        'Routine Développement Athlétique',
        'Programme Massif et Fort',
        'Plan d\'Entraînement Explosif',
        'Circuit de Prise de Masse',
        'Programme Force Fonctionnelle',
        'Routine de Sculpture Physique',
        'Plan d\'Entraînement Dynamique',
        'Programme de Renforcement Complet',
        'Entraînement de Musculation Élite',
        'Plan de Construction Musculaire',
        'Routine Corps-à-Tout-Épreuve',
        'Programme Force et Endurance',
        'Plan d\'Entraînement Hardcore',
        'Routine de Développement Musculaire',
        'Programme de Musculation Polyvalent',
        'Entraînement Intensif pour la Sculpture',
        'Plan d\'Entraînement de Perte de Poids',
        'Programme de Remise en Forme Cardio',
        'Entraînement de CrossFit Intense',
        'Plan d\'Entraînement pour la Flexibilité',
        'Programme de Renforcement du Bas du Corps',
        'Routine de Yoga pour la Souplesse',
        'Plan d\'Entraînement de Boxe Cardio',
        'Programme d\'Entraînement en Circuit HIIT',
        'Entraînement de Musculation pour Débutants',
        'Plan d\'Entraînement de Préparation à la Compétition',
        'Programme de Natation pour l\'Endurance',
        'Routine de Stretching pour la Mobilité',
        'Plan d\'Entraînement de Course à Pied',
        'Programme de Renforcement du Haut du Corps',
        'Entraînement de Danse Aérobique',
        'Plan d\'Entraînement de Kickboxing',
        'Programme de Yoga Vinyasa',
        'Routine de Musculation pour la Force du Dos',
        'Plan d\'Entraînement de Musculation en Split',
        'Programme de Pilates pour le Core',
    ];

    private $workoutCategories = [
        'Force pure',
        'Hypertrophie maximale',
        'Endurance musculaire',
        'Perte de poids',
        'Prise de masse',
        'Entraînement fonctionnel',
        'Sculpture corporelle',
        'Circuit d\'explosivité',
        'Musculation pour femmes',
        'Entraînement en circuit',
        'Musculation athlétique',
        'Entraînement de puissance',
        'Entraînement HIIT',
        'Renforcement du noyau',
        'Musculation pour débutants',
        'Entraînement du haut du corps',
        'Entraînement du bas du corps',
        'Musculation pour seniors',
        'Programme de récupération',
        'Entraînement à domicile',
    ];

    private $coachPictures = [
        'https://images.pexels.com/photos/8520081/pexels-photo-8520081.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        'https://images.pexels.com/photos/5669183/pexels-photo-5669183.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        'https://images.pexels.com/photos/8744821/pexels-photo-8744821.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6456176/pexels-photo-6456176.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/416809/pexels-photo-416809.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1153370/pexels-photo-1153370.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1300526/pexels-photo-1300526.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/936075/pexels-photo-936075.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/68468/pexels-photo-68468.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4056529/pexels-photo-4056529.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3768918/pexels-photo-3768918.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/927437/pexels-photo-927437.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6551136/pexels-photo-6551136.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4720309/pexels-photo-4720309.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1764506/pexels-photo-1764506.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3799312/pexels-photo-3799312.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4164512/pexels-photo-4164512.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4164507/pexels-photo-4164507.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/997489/pexels-photo-997489.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/7869515/pexels-photo-7869515.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    private $nutritionPictures = [
        'https://images.pexels.com/photos/5946103/pexels-photo-5946103.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5967852/pexels-photo-5967852.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5273044/pexels-photo-5273044.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/videos/8844925/avocado-client-diet-diversity-8844925.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=699.825&fit=crop&h=1133.05',
        'https://images.pexels.com/photos/6994261/pexels-photo-6994261.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5331065/pexels-photo-5331065.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4553031/pexels-photo-4553031.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6740511/pexels-photo-6740511.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/2988229/pexels-photo-2988229.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4940719/pexels-photo-4940719.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1640768/pexels-photo-1640768.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5966631/pexels-photo-5966631.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4113831/pexels-photo-4113831.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6607386/pexels-photo-6607386.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5692195/pexels-photo-5692195.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1092730/pexels-photo-1092730.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/566566/pexels-photo-566566.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1196516/pexels-photo-1196516.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1660027/pexels-photo-1660027.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1630588/pexels-photo-1630588.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    private $healthPictures = [
        'https://images.pexels.com/photos/3822583/pexels-photo-3822583.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3683040/pexels-photo-3683040.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5340280/pexels-photo-5340280.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5863366/pexels-photo-5863366.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4047073/pexels-photo-4047073.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/806427/pexels-photo-806427.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/105028/pexels-photo-105028.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/356040/pexels-photo-356040.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/53404/scale-diet-fat-health-53404.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5407206/pexels-photo-5407206.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4225880/pexels-photo-4225880.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5726693/pexels-photo-5726693.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3683074/pexels-photo-3683074.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5327584/pexels-photo-5327584.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3683102/pexels-photo-3683102.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1350560/pexels-photo-1350560.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/2383010/pexels-photo-2383010.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4386467/pexels-photo-4386467.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4167541/pexels-photo-4167541.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3762879/pexels-photo-3762879.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    private $sportPictures = [
        'https://images.pexels.com/photos/1865131/pexels-photo-1865131.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1886487/pexels-photo-1886487.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4753928/pexels-photo-4753928.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5345858/pexels-photo-5345858.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3764014/pexels-photo-3764014.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4752861/pexels-photo-4752861.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4789457/pexels-photo-4789457.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/35009/runner-marathon-military-afghanistan.jpg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4164761/pexels-photo-4164761.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/7289296/pexels-photo-7289296.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/416809/pexels-photo-416809.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/863977/pexels-photo-863977.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/8520627/pexels-photo-8520627.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/703012/pexels-photo-703012.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/2468339/pexels-photo-2468339.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/685532/pexels-photo-685532.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1638336/pexels-photo-1638336.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    private $programPictures = [
        'https://images.pexels.com/photos/1552249/pexels-photo-1552249.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3076511/pexels-photo-3076511.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4498605/pexels-photo-4498605.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5384160/pexels-photo-5384160.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6012015/pexels-photo-6012015.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/5067737/pexels-photo-5067737.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/348489/pexels-photo-348489.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/2011383/pexels-photo-2011383.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3618726/pexels-photo-3618726.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/2331055/pexels-photo-2331055.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4056529/pexels-photo-4056529.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4164761/pexels-photo-4164761.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/8611242/pexels-photo-8611242.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4058411/pexels-photo-4058411.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6454069/pexels-photo-6454069.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/7991645/pexels-photo-7991645.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6767987/pexels-photo-6767987.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4348633/pexels-photo-4348633.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1954524/pexels-photo-1954524.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/38630/bodybuilder-weight-training-stress-38630.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    private $exercicePictures = [
        'https://images.pexels.com/photos/7672103/pexels-photo-7672103.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3076514/pexels-photo-3076514.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1552106/pexels-photo-1552106.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6550852/pexels-photo-6550852.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6550857/pexels-photo-6550857.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/136405/pexels-photo-136405.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/1552102/pexels-photo-1552102.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3837781/pexels-photo-3837781.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/4162487/pexels-photo-4162487.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3838926/pexels-photo-3838926.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/371049/pexels-photo-371049.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/6550851/pexels-photo-6550851.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/15046713/pexels-photo-15046713/free-photo-of-homme-personne-fitness-entrainement.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3837293/pexels-photo-3837293.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/7289236/pexels-photo-7289236.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3768913/pexels-photo-3768913.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/866019/pexels-photo-866019.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/7674484/pexels-photo-7674484.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/3076514/pexels-photo-3076514.jpeg?auto=compress&cs=tinysrgb&w=600',
        'https://images.pexels.com/photos/7674482/pexels-photo-7674482.jpeg?auto=compress&cs=tinysrgb&w=600',
    ];

    private $nutritionTitles = [
        'Les bienfaits des légumes verts pour la santé',
        'Comment maintenir une alimentation équilibrée',
        'Les protéines : sources et rôles essentiels',
        'Les avantages de manger des fruits tous les jours',
        'Les aliments riches en antioxydants et leur importance',
        'L\'impact du sucre sur la santé et comment le réduire',
        'Les graisses saines vs les graisses malsaines : ce que vous devez savoir',
        'Le rôle crucial des fibres dans une alimentation saine',
        'L\'influence de l\'alimentation sur la santé cardiaque',
        'Comment lire et comprendre les étiquettes nutritionnelles',
        'L\'importance de l\'hydratation pour une meilleure nutrition',
        'Les bienfaits des régimes alimentaires riches en oméga-3',
        'Aliments à éviter pour une meilleure santé digestive',
        'Les secrets de la nutrition pour une peau éclatante',
        'Les effets de la nutrition sur la gestion du poids',
        'Les allergies alimentaires : symptômes et solutions',
        'Nutrition sportive : optimisez vos performances',
        'Le lien entre la nutrition et la santé mentale',
        'Le rôle des vitamines et des minéraux dans l\'alimentation',
        'Manger de manière responsable : conseils et astuces',
        'Le régime méditerranéen : un modèle de nutrition saine',
        'Comment planifier des repas sains pour toute la famille',
        'L\'alimentation et le vieillissement : rester en forme avec l\'âge',
        'Alimentation et immunité : renforcez votre système immunitaire',
        'La nutrition pendant la grossesse : les besoins essentiels',
        'Les super-aliments : des alliés pour votre santé',
        'L\'importance de la diversité alimentaire dans votre assiette',
        'L\'alimentation végétalienne : équilibrer vos nutriments',
        'Les bienfaits de la cuisson à la vapeur pour préserver les nutriments',
        'Les effets du jeûne intermittent sur le métabolisme',
        'La nutrition et la gestion du diabète : conseils pratiques',
        'Le pouvoir des épices pour la santé et la saveur',
        'La nutrition et la prévention des maladies neurodégénératives',
        'L\'importance des acides gras essentiels dans votre alimentation',
        'Les bienfaits du thé vert pour la santé',
        'Les aliments biologiques : sont-ils vraiment meilleurs pour vous ?',
        'Nutrition et énergie : les glucides comme carburant',
        'Le rôle des probiotiques dans la santé digestive',
        'Les choix alimentaires pour favoriser la santé des os',
        'La nutrition et la santé rénale : protéger vos reins',
        'La gestion des allergies alimentaires chez les enfants',
        'L\'alimentation anti-inflammatoire pour réduire les douleurs',
        'Les aliments fermentés : des trésors pour la digestion',
        'Les besoins nutritionnels spécifiques des personnes âgées',
        'Nutrition et pression artérielle : comment la contrôler',
        'Le petit-déjeuner : le repas le plus important de la journée ?',
        'Le végétarisme : une option saine et éthique',
        'Alimentation et santé oculaire : prévenir la dégénérescence maculaire',
        'Le rôle des micronutriments dans votre régime alimentaire',
        'L\'influence de la nutrition sur la qualité du sommeil',
    ];

    private $healthTitles = [
        'Les clés d\'une vie saine et équilibrée',
        'La prévention des maladies : adoptez de bonnes habitudes',
        'L\'importance de l\'exercice physique pour la santé',
        'Gestion du stress : stratégies pour une meilleure santé mentale',
        'La qualité du sommeil et son impact sur la santé',
        'La santé cardiaque : facteurs de risque et prévention',
        'La gestion du poids : astuces pour un mode de vie sain',
        'La prévention du cancer : alimentation et comportements clés',
        'Les bienfaits de la méditation pour la santé',
        'L\'importance des bilans de santé réguliers',
        'Santé bucco-dentaire : conseils pour un sourire radieux',
        'Les effets de la pollution de l\'air sur la santé',
        'Le rôle de la vaccination dans la prévention des maladies',
        'Santé des yeux : prévention et soins essentiels',
        'La santé des os et la prévention de l\'ostéoporose',
        'Les avantages de la relaxation pour réduire le stress',
        'Les allergies saisonnières : symptômes et solutions',
        'Gérer les affections chroniques : améliorer la qualité de vie',
        'La santé des enfants : conseils pour des familles en bonne santé',
        'Prévention des infections : hygiène et bonnes pratiques',
        'La santé des femmes : suivi médical et prévention',
        'Santé des hommes : les examens essentiels à ne pas négliger',
        'La santé mentale des adolescents : signes à surveiller',
        'Santé au travail : ergonomie et bien-être au bureau',
        'Lutter contre la dépendance : conseils pour une vie plus saine',
        'La prévention des infections respiratoires : gestes simples',
        'Le rôle de la génétique dans la santé et les maladies',
        'La santé intestinale : un lien essentiel avec votre bien-être',
        'Les bienfaits de la thérapie par l\'art sur la santé mentale',
        'La gestion de la douleur chronique : approches et traitements',
        'Le sommeil paradoxal : comprendre vos rêves et leur signification',
        'Santé et technologie : les avantages et les pièges de la vie numérique',
        'Les bienfaits de la danse pour la santé physique et mentale',
        'La prévention des accidents domestiques : votre maison en sécurité',
        'Santé des animaux de compagnie : prendre soin de vos fidèles amis',
        'La santé des voyageurs : conseils pour un voyage sans soucis',
        'L\'impact de la musique sur l\'humeur et le bien-être',
        'La santé mentale des vétérans : soutien et sensibilisation',
        'Santé des ongles et des cheveux : signes de carence à surveiller',
        'La science de la longévité : secrets pour vieillir en bonne santé',
        'La médecine alternative : options et considérations',
        'Santé environnementale : préserver la planète pour notre bien-être',
        'Santé dentaire des enfants : habitudes de soins et prévention',
        'Santé sexuelle : éducation et bien-être intime',
        'Le microbiote intestinal : clé de la santé globale',
        'Le rôle des antioxydants dans la prévention du vieillissement',
        'La gestion de la colère : conseils pour une meilleure santé émotionnelle',
        'Santé cardiovasculaire : contrôler l\'hypertension et le cholestérol',
        'Santé des pieds : prévention des problèmes courants',
        'Les avantages de la naturopathie pour une santé holistique',
    ];

    private $sportTitles = [
        'Les bienfaits de l\'exercice physique sur la santé',
        'Comment choisir le sport qui vous convient le mieux',
        'Les principes de l\'entraînement sportif : progression et récupération',
        'Nutrition pour les athlètes : carburant pour la performance',
        'La prévention des blessures sportives : conseils essentiels',
        'L\'importance de l\'échauffement et des étirements avant le sport',
        'Améliorer sa condition physique : conseils pour les débutants',
        'Le rôle du coach sportif dans l\'atteinte de vos objectifs',
        'Sport en plein air : profitez des bienfaits de la nature',
        'L\'impact du sport sur la santé mentale et le bien-être',
        'Le sport en famille : activités amusantes pour tous',
        'La compétition sportive : gérer la pression et les attentes',
        'Les sports d\'équipe : renforcer la camaraderie et la coopération',
        'Le sport et la perte de poids : stratégies efficaces',
        'Les bienfaits du yoga et de la méditation pour les sportifs',
        'Sport et vieillissement : rester actif à tout âge',
        'La course à pied : guide pour débutants et coureurs confirmés',
        'Les sports nautiques : plaisir et activité physique',
        'Le cyclisme : mode de transport sain et sportif',
        'Sports d\'hiver : préparation et sécurité en montagne',
        'La boxe : une forme d\'entraînement complet et dynamique',
        'Le fitness à la maison : s\'équiper et s\'entraîner efficacement',
        'Les sports extrêmes : adrénaline et prudence',
        'Le tennis : un sport de raquette accessible à tous',
        'Le golf : précision, calme et détente sur le green',
        'Le CrossFit : un entraînement intensif pour tous les niveaux',
        'Santé mentale et sport : comment le sport peut aider à combattre la dépression',
        'L\'importance de la récupération après l\'entraînement',
        'La gymnastique artistique : grâce, force et flexibilité',
        'Le basketball : un sport d\'équipe passionnant',
        'Sports de raquette : le badminton, le squash et le tennis de table',
        'Le ski de fond : un exercice cardiovasculaire en plein air',
        'Le pouvoir de la méditation dans le sport de haut niveau',
        'Les bienfaits de la natation pour le corps et l\'esprit',
        'L\'escalade : un sport d\'aventure pour tous les âges',
        'Le kayak et le canoë : découvrez la beauté des rivières et des lacs',
        'L\'athlétisme : une passion pour la vitesse, la force et l\'endurance',
        'La danse : une forme artistique d\'expression corporelle',
        'Le cyclisme sur route : de la balade au vélo de compétition',
        'Le saut à la perche : technique, force et agilité',
        'Le patinage artistique : élégance et performances acrobatiques',
        'Le powerlifting : force brute et compétition',
        'Les sports de combat : MMA, judo, et lutte',
        'Le kickboxing : cardio, renforcement musculaire et autodéfense',
        'Le rugby : un sport d\'équipe physique et stratégique',
        'Le baseball : l\'art de frapper et lancer la balle',
        'Les sports de glisse : skateboard, roller, et BMX',
        'Le triathlon : défis d\'endurance et de variété',
        'La voile : naviguer pour le plaisir et la compétition',
        'Le handball : vitesse, agilité et tir précis',
    ];

    public function exercices()
    {
        return $this->exercices;
    }

    public function workoutPrograms()
    {
        return $this->workoutPrograms;
    }

    public function workoutCategories()
    {
        return $this->workoutCategories;
    }

    public function coachPictures()
    {
        return $this->coachPictures;
    }

    public function nutritionPictures()
    {
        return $this->nutritionPictures;
    }

    public function healthPictures()
    {
        return $this->healthPictures;
    }

    public function sportPictures()
    {
        return $this->sportPictures;
    }

    public function programPictures()
    {
        return $this->programPictures;
    }

    public function exercicePictures()
    {
        return $this->exercicePictures;
    }

    public function nutritionTitles()
    {
        return $this->nutritionTitles;
    }

    public function healthTitles()
    {
        return $this->healthTitles;
    }

    public function sportTitles()
    {
        return $this->sportTitles;
    }
}