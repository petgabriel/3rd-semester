#pragma once

#include <string>
#include <iostream>

using namespace std;

class RingBuffer
{
private:
    int* ring_buf;
    int buf_size;
    int pop_index;
    int push_index;

public:
    RingBuffer(int);

    void push(int);
    int pop();
    bool empty();
    int size();
    int capacity();
};
