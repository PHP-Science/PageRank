<h1 align="center">
PageRank
</h1>

<p align="center">
	<a href="https://github.com/PHP-Science/PageRank/actions">
		<img src="https://github.com/php-science/pagerank/workflows/tests/badge.svg" 
		alt="GoDoc" />
	</a>
	<a href="https://codecov.io/gh/PHP-Science/PageRank">
		<img src="https://codecov.io/gh/PHP-Science/PageRank/branch/master/graph/badge.svg" 
	    alt="License: MIT" />
	</a>
</p>

<p align="center">
This source code is an OOP implementation of the PageRank algorithm, under MIT licence.
<br />The minimum required PHP version is 7.4.
</p>

## Workflow

* It calculates the initial ranking values. At the first iteration, all the nodes have the same rank.
* Iterates the nodes using the power method/iteration technique over and over again until it reaches the maximum 
iteration number.
* However, the iteration stops when the ranks are accurate enough even if the max iteration didn't reach its limit.
* The accuracy measured by the float epsilon constant.
* Getting, setting, updating the nodes from the resource is a responsibility of the NodeDataSourceStrategyInterface.
* The package provides a simple implementation of the NodeDataSourceStrategyInterface that only keeps the nodes in the 
memory. Another way of implementing the NodeDataSourceStrategyInterface could be a simple class that uses an ORM to
handle the node collection.

## Install

```
composer require php-science/pagerank
```

## Example

```php
$dataSource = $this->getYourDataSource();

$nodeBuilder = new NodeBuilder();
$nodeCollectionBuilder = new NodeCollectionBuilder();
$strategy = new MemorySourceStrategy(
    $nodeBuilder,
    $nodeCollectionBuilder,
    $dataSource
);

$rankComparator = new RankComparator();
$ranking = new Ranking(
    $rankComparator,
    $strategy
);

$pageRankAlgorithm = new PageRankAlgorithm(
    $ranking,
    $strategy
);

$maxIteration = 100;
$nodeCollection = $pageRankAlgorithm->run($maxIteration);

var_dump($nodeCollection->getNodes());
```

## Functional Sample

* test: [Functional test case](https://github.com/PHP-Science/PageRank/blob/master/tests/functional/Service/PageRankAlgorithmTest.php)
* running the test: ```composer test```
