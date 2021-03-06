<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="<?php echo $pluralVar; ?> view clearfix">
<?php
	echo "<?php\n";
	echo "\t\t\$sidebar = \$this->Html->link(__('Edit " . $singularHumanName ."'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'list-group-item'));\n";
	echo "\t\t\$navbar = \$this->Html->tag('li', \$this->Html->link(__('Edit " . $singularHumanName ."'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])));\n";
	echo "\t\t\$sidebar .= \$this->Html->link(__('Delete " . $singularHumanName . "'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'list-group-item', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-$modelClass' . \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
	echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('Delete " . $singularHumanName . "'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('data-toggle' => 'modal', 'data-target' => '#deleteModal-$modelClass' . \${$singularVar}['{$modelClass}']['{$primaryKey}'])));\n";
	echo "\t\t\$modals[] = \$this->element('delete_modal', array('object_id' => \${$singularVar}['{$modelClass}']['{$primaryKey}'], 'controller' => '$pluralVar', 'model' => '$modelClass'));\n";
	echo "\t\t\$sidebar .= \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index'), array('class' => 'list-group-item'));\n";
	echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index')));\n";
	echo "\t\t\$sidebar .= \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add'), array('class' => 'list-group-item'));\n";
	echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add')));\n";

	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != strtolower($this->name) && !in_array($details['controller'], $done)) {
				echo "\t\t\$sidebar .= \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('class' => 'list-group-item'));\n";
				echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')));\n";
				echo "\t\t\$sidebar .= \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'list-group-item'));\n";
				echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')));\n";
				$done[] = $details['controller'];
			}
		}
	}
	echo "?>\n";
?>
<?php echo "<?php echo \$this->element('cake_navigation', compact('sidebar', 'navbar')); ?>"; ?>
<div class="col-lg-10 col-12">
	<h2><?php echo "<?php echo __('{$singularHumanName}'); ?>"; ?></h2>
	<table class="table table-striped">
<?php
foreach ($fields as $field) {
	echo "\t<tr>\n";
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t<th><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></th>\n";
				echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</td>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
		echo "\t\t<td>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</td>\n";
	}
	echo "\t</tr>\n";
}
?>
	</table>
</div>
</div>
<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
	<div class="related">
		<h3><?php echo "<?php echo __('Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
		<table class="table table-striped">
	<?php
			foreach ($details['fields'] as $field) {
				echo "\t<tr>\n";
				echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
				echo "\t\t<td>\n\t<?php echo \${$singularVar}['{$alias}']['{$field}']; ?>\n&nbsp;</td>\n";
				echo "\t</tr>\n";
			}
	?>
		</table>
	<?php echo "<?php endif; ?>\n"; ?>
		<div class="actions">
			<ul class="list-unstyled">
				<li><?php echo "<?php echo \$this->Html->link(__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => 'btn btn-default')); ?></li>\n"; ?>
			</ul>
		</div>
	</div>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="related">
	<h3><?php echo "<?php echo __('Related " . $otherPluralHumanName . "'); ?>"; ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
	<table class="table table-striped table-bordered">
	<tr>
<?php
			foreach ($details['fields'] as $field) {
				echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
			}
?>
		<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
	</tr>
<?php
echo "\t<?php
		\$i = 0;
		foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
		echo "\t\t<tr>\n";
			foreach ($details['fields'] as $field) {
				echo "\t\t\t<td><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
			}

			echo "\t\t\t<td class=\"actions\">\n";
			echo "\t\t\t\t<?php echo \$this->Html->link(__('View'), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-default btn-xs')); ?>\n";
			echo "\t\t\t\t<?php echo \$this->Html->link(__('Edit'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-default btn-xs')); ?>\n";
			echo "\t\t\t\t<?php echo \$this->Html->link(__('Delete'), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-default btn-xs', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-$alias' . \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n"; 
			echo "\t\t\t\t<?php \$modals[] = \$this->element('delete_modal', array('object_id' => \${$otherSingularVar}['{$details['primaryKey']}'], 'controller' => '{$details['controller']}', 'model' => '$alias')); ?>\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";

echo "\t<?php endforeach; ?>\n";
?>
	</table>
<?php echo "<?php endif; ?>\n\n"; ?>
	<div class="actions">
		<ul class="list-unstyled">
			<li><?php echo "<?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'btn btn-default')); ?>"; ?> </li>
		</ul>
	</div>
</div>
<?php endforeach; ?>
<?php echo "<?php if (!empty(\$modals)) echo implode(\"\\n\", \$modals); ?>\n"; ?>
