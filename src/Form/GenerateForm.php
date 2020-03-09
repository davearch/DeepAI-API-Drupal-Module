<?php  
/**  
 * @file  
 * Contains Drupal\welcome\Form\MessagesForm.  
 */  
namespace Drupal\deepai\Form;

use Drupal\deepai\Generator\DeepaiClient;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;

class GenerateForm extends FormBase
{
    /**
     * @var DeepaiClient
     */
    protected $deepaiClient;

    /**
     * Class Constructor.
     */
    public function __construct(DeepaiClient $deepaiClient)
    {
        $this->deepaiClient = $deepaiClient;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static($container->get('deepai.deepai_client'));
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'deepai_generate_node_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['number_of_nodes'] = [
            '#type' => 'number',
            '#title' => t('Quantity'),
            '#description' => $this->t('Choose the number of Nodes (Article) to generate.'),
        ];
        $form['actions'] = [
            '#type' => 'actions',
        ];
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#description' => $this->t('Submit, #type = submit'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $number_of_nodes = $form_state->getValue('number_of_nodes');
        if (strlen($number_of_nodes) != 1) {
            $form_state->setErrorByName('number_of_nodes', $this->t('Hold off on doing more (or less) than one for now.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $amount = $form_state->getValue('number_of_nodes');

        for ($i = 0; $i < $amount; $i++) {
            $node = Node::create([
                'type' => 'article',
                'langcode' => 'en',
                'created' => REQUEST_TIME,
                'changed' => REQUEST_TIME,
                'uid' => 1,
                'title' => 'generated_'.rand(),
                'body' => [
                    'summary' => '',
                    'value' => $this->deepaiClient->generate(),
                    'format' => 'full_html',
                ],
            ]);
            $node->save();
            if ($node->id()) {
                drupal_set_message(t('You successfully created node %node.', ['%node' => $node->getTitle()]));
            } else {
                drupal_set_message(t('The post could not be saved.'), 'error');
                $form_state->setRebuild();
            }
        }
    }
}