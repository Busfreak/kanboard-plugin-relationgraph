<div class="page-header">
    <h2><?= t('Relation Graph') ?> : <?= $title ?></h2>
</div>

<style type="text/css">
    #mynetwork {width: 900px;height: 700px;border: 1px solid lightgray;}
</style>

<div id="mynetwork"></div>

<div id="graph-nodes" style="display:none">
    <?php $items = []; ?>
    <?php foreach ($graph['nodes'] as $node) : ?>
        <?php
        $titleItems = [];

        if ($node['project_id'] != $task['project_id']) {
            $titleItems[] = 'Project: ' . $node['project'];
        }

        if ($node['score'] > 0) {
            $titleItems[] = 'Score: ' . $node['score'];
        }

        if ($node['assignee'] != '') {
            $titleItems[] = 'Assignee: ' . $node['assignee'];
        }

        $titleItems[] = 'Priority: ' . $node['priority'];
        $titleItems[] = 'Column: ' . $node['column'];

        $items[] = [
            'id' => $node['id'],
            'label' => '#' . $node['id'] . ' ' . $node['title'],
            'color' => $node['active'] ? '#DDE8D3' : '#e8d3d3',
            'shape' => 'box',
            'size' => '20',
            'scaling' => [
                'min' => 30,
                'max' => 30
            ],
            'shadow' => 'true',
            'mass' => 2,
            'title' => join('<br>', $titleItems)
        ];
        ?>
    <?php endforeach ?>
    <?php echo json_encode($items) ?>
</div>

<div id="graph-edges" style="display:none">
    <?php $items = [] ?>
    <?php foreach ($graph['edges'] as $task => $links) : ?>
        <?php foreach ($links as $edge => $type) : ?>
            <?php
            $items[] = [
                'from' => $task,
                'to' => $edge,
                'label' => t($type),
                'length' => 200,
                'font' => ['align' => 'top'],
                'arrows' => 'to'
            ];
            ?>
        <?php endforeach ?>
    <?php endforeach ?>
    <?php echo json_encode($items) ?>
</div>

<?= $this->asset->js('plugins/Relationgraph/Asset/Javascript/vis/vis.js') ?>
<?= $this->asset->css('plugins/Relationgraph/Asset/Javascript/vis/vis.css') ?>
<?= $this->asset->js('plugins/Relationgraph/Asset/Javascript/GraphBuilder.js') ?>
