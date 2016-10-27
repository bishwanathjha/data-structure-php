<?php
/**
 * @author Bishwanath Jha <bishwanathkj@gmail.com>
 * Node Class represent a node of linked list
 */
class Node
{
	public $data = null;
	public $next = null;
	
	public function __construct($data)
	{
		if (!$data) {
			throw new Exception("Invalid data given");
		}

		$this->data = $data;
	}
}

/**
 * @author Bishwanath Jha <bishwanathkj@gmail.com>
 * Linked List class
 */
class LinkedList 
{
	// First element of List
	/* @var $head Node */
	public $head = null;

	// Holds the number of element in linked list
	static private $count;

	public function __construct() {
		$this->head = null;
		self::$count = 0;
	}

	public function IsEmpty() {
		return (self::$count == 0);
	}

	public function GetCount() {
		return self::$count;
	}

	public function Append($item) {
		// If the linked list is empty then insert it as first element
		if ($this->head === null) {
			$this->head = new Node($item);
		} else { // Otherwise reach to end of list and append the item
			$current = $this->head;

			// looping thru end of list
			while($current->next !== null) {
				$current = $current->next;
			}

			// Se the last node to point new node
			$current->next = new Node($item);
		}

		self::$count++;
	}

	public function Prepend($item) {
		$node = new Node($item);
		
		// If the linked list is empty then insert it as first element
		if ($this->head === null) {
			$this->head = $node;
		} else {
			// Link the node next to head and set the node as head
			$node->next = $this->head;
			$this->head = $node;
		}

		self::$count++;
	}

	// Insert data in list
	public function Insert($item, $position = null) {
		if($position && ($position < 1 || (!is_int($position) && $position != 'start' && $position != 'end'))) {
			throw new Exception("Invalid value of parameter position");
		}

		if ($position > self::$count) {
			throw new Exception('Position is greater than length of linked list');
		}

		// If position is not given or end then append at the end
		if(!$position || $position == 'end' ) {
			$this->Append($item);
		} elseif($position == 'start' || $position == 1) {
			$this->Prepend($item);
		} else {
			$current = $this->head;
			$listPos = 2;
			while($current->next !== null) {
				$previous = $current;
				$next = $current->next;

				if ($listPos == $position) {
					$node = new Node($item);
					$previous->next = $node;
					$node->next = $next;
					self::$count++;
					break;
				}

				$listPos++;
				$current = $current->next;
			}
		}
	}

	// Delete a node on data
	public function Delete($nodeData) {
		$current = $this->head;

		// If its first node then delete it
		if ($current->data == $nodeData) {
			$this->head = ($current->next == null) ? null : $current->next;
			self::$count--;
			return;
		}

		$count = 2;
		while($current->next->data != $nodeData && $count <= self::$count) {
            $current = $current->next;
            $count++;

            if ($count == self::$count) {
            	echo "Data ($nodeData) not found in linked list \n";
            	return;
            }
        }

        $current->next = $current->next->next;
        self::$count--;
	}

	public function PrintList() {
		if ($this->IsEmpty()) {
			echo "Linked list is empty \n";

			return;
		}

		$current = $this->head;
		while ($current !== null) {
			echo $current->data . '->';
			$current = $current->next;
		}

		echo "\n";
	}

}


// Create a new linklist class
$LinkL = new LinkedList();
$LinkL->Append(200); // Add 200
$LinkL->Append(400); // Add 400
$LinkL->Append(500); // Add 500
$LinkL->Prepend(100); // Add 100 at first
$LinkL->Insert(300, 3); // Add 300 at 3 the place staring from 1
$LinkL->Delete(200);
$LinkL->Delete(300);

$LinkL->PrintList(); // print the list
echo $LinkL->GetCount();
