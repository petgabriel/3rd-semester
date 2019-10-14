#include "TestIncludes.h"
#include "RingBuffer.h"


TEST(RingBuffer, Create)
{
    auto buffer = RingBuffer(10);
}

TEST(RingBuffer, PopAndPush)
{
    auto buffer = RingBuffer(1);

    buffer.push(15);

    ASSERT_EQ(15,buffer.pop());
}

TEST(RingBuffer, Empty)
{
    auto buffer = RingBuffer(12);

    ASSERT_EQ(true,buffer.empty());
}

TEST(RingBuffer, Size)
{
    auto buffer = RingBuffer(9);

    ASSERT_EQ(0,buffer.size());
}

TEST(RingBuffer, Capacity)
{
    const int CAP = 8;

    auto buffer = RingBuffer(CAP);

    ASSERT_EQ(CAP,buffer.capacity());
}

TEST(RingBuffer, PopAndPushCap1)
{
    auto buffer = RingBuffer(1);

    buffer.push(10);

    ASSERT_EQ(10, buffer.pop());
}

TEST(RingBuffer, PopAndPushCap3)
{
    auto buffer = RingBuffer(3);

    buffer.push(1);
    buffer.push(2);
    buffer.push(3);
    buffer.push(4);
    buffer.push(5);


    ASSERT_EQ(3, buffer.pop());
    ASSERT_EQ(4, buffer.pop());
    ASSERT_EQ(5, buffer.pop());
    ASSERT_EQ(true, buffer.empty());
}