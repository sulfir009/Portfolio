class ListNode:
    def __init__(self, val=0, next=None):
        self.val = val
        self.next = next

def swap_pairs(head):
    if not head or not head.next:
        return head
    new_head = head.next
    head.next = swap_pairs(head.next.next)
    new_head.next = head
    return new_head
