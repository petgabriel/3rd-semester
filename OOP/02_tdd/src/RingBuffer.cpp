#include "RingBuffer.h"

RingBuffer::RingBuffer(int n)
{
    ring_buf = (int*)calloc(n,sizeof(int));
    buf_size = n;
    push_index = 0;
    pop_index = 0;
}

void RingBuffer::push(int val)
{
    ring_buf[push_index] = val;

    if( push_index == pop_index and !size() )
    {
        pop_index = ( push_index + 1 ) % buf_size;
    }

    push_index = ( push_index + 1 ) % buf_size;
}

int RingBuffer::pop()
{
    if( ring_buf[pop_index] != 0 )
    {
        int tmp = ring_buf[pop_index];

        ring_buf[pop_index] = 0;
        pop_index = (pop_index + 1) % buf_size;

        return tmp;
    }

    return 0;
}

bool RingBuffer::empty()
{
    return !abs(push_index - pop_index );
}

int RingBuffer::size()
{
    return abs(pop_index - push_index);
}

int RingBuffer::capacity()
{
    return buf_size;
}