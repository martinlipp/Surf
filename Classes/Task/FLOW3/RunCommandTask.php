<?php
namespace TYPO3\Surf\Task\FLOW3;

/*                                                                        *
 * This script belongs to the FLOW3 package "TYPO3.Surf".                 *
 *                                                                        *
 *                                                                        */

use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Task for running arbitrary FLOW3 commands
 *
 */
class RunCommandTask extends \TYPO3\Surf\Domain\Model\Task {

	/**
	 * @FLOW3\Inject
	 * @var \TYPO3\Surf\Domain\Service\ShellCommandService
	 */
	protected $shell;

	/**
	 * Execute this task
	 *
	 * @param \TYPO3\Surf\Domain\Model\Node $node
	 * @param \TYPO3\Surf\Domain\Model\Application $application
	 * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
	 * @param array $options
	 * @return void
	 */
	public function execute(Node $node, Application $application, Deployment $deployment, array $options = array()) {
		if (!isset($options['command'])) {
			throw new \Exception('Missing option "command".', 1319201396);
		}

		$arguments = escapeshellarg(isset($options['arguments']) ? $options['arguments'] : '');

		$targetPath = $deployment->getApplicationReleasePath($application);
		$this->shell->executeOrSimulate('cd ' . $targetPath . ' && FLOW3_CONTEXT=Production ./flow3 ' . $options['command'] . $arguments, $node, $deployment);
	}

	/**
	 * Simulate this task
	 *
	 * @param Node $node
	 * @param Application $application
	 * @param Deployment $deployment
	 * @param array $options
	 * @return void
	 */
	public function simulate(Node $node, Application $application, Deployment $deployment, array $options = array()) {
	}

	/**
	 * Rollback the task
	 *
	 * @param \TYPO3\Surf\Domain\Model\Node $node
	 * @param \TYPO3\Surf\Domain\Model\Application $application
	 * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
	 * @param array $options
	 * @return void
	 */
	public function rollback(Node $node, Application $application, Deployment $deployment, array $options = array()) {
		// TODO Implement rollback
	}

}
?>